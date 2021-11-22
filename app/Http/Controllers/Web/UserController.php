<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Type;
use App\Models\User;
use DateTime;
use DateTimeZone;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConvertTimezone 
{
    public static function convert_timezone($original_time){
        $datetime = new DateTime($original_time);
        $vi = new DateTimeZone('Asia/Ho_Chi_Minh');
        $datetime->setTimezone($vi);
        return $datetime->format('H:i  d/m/Y');
    }
}
class UserController extends Controller
{
    public function showInformation(){
        $breadCrumbs = [
            [
                'name' => 'Người dùng',
                'link' => '#',
            ],
            [
                'name' => 'Thông tin cá nhân',
                'link' => '/user/information',
            ]
        ];
        $user = Auth::guard('web')->user();
        $image = null;
        if (filter_var(Auth::guard('web')->user()->avatar, FILTER_VALIDATE_URL)){
            $image = Auth::guard('web')->user()->avatar;
        } else {
            $image = Storage::disk('user-avatar')->url(Auth::guard('web')->user()->avatar == null ? 'unknown.png' : Auth::guard('web')->user()->avatar);
        }
        return view('frontend.account.information',compact(['user','breadCrumbs','image']));
    }
    public function updateInformation(Request $request){
        if( $request->ajax()){
            $id = Auth::guard('web')->user()->id;
            if ($file = $request->input('upload')){
                $image_parts = explode(";base64,", $file);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = $id.'.png';
                Storage::disk('user-avatar')->delete($imageName);
                Storage::disk('user-avatar')->put($imageName, $image_base64);
                User::where('id',$id)->update([
                    'avatar' => $imageName,
                    'updated_at' => now()
                ]);
                session()->flash('success', 'Cập nhật ảnh đại diện thành công');
                return response()->json([
                    'result' => 'success',
                ]);
            }
        };
        if ($request->has(['name', 'phonenumber'])) {
            $name = $request->input('name');
            $phonenumber = $request->input('phonenumber');
            User::where('id',Auth::guard('web')->user()->id)->update([
                'name' => $name,
                'phonenumber' => $phonenumber,
                'updated_at' => now()
            ]);
            session()->flash('success', 'Cập nhật thông tin thành công');
            return back();
        }
    }

    public function orders(){
        $orders = Order::where('user_id',Auth::guard('web')->user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($orders as $order){
            $order->ward = Ward::where('id',$order->ward_id)->first();
            $order->district = District::where('id',$order->ward->district_id)->first();
            $order->province = Province::where('id',$order->district->province_id)->first();
            
            $order->created_at_converted = ConvertTimezone::convert_timezone($order->created_at);;
            $order->status = 'Đơn đã được tạo';
            if ($order->confirmed_at != null){
                $order->status = 'Đơn đã được xác nhận';
            }
            if ($order->start_deliver_at != null){
                $order->status = 'Đơn đang được giao';
            } 
            if ($order->delivered_at != null){
                $order->status = 'Đơn đã giao xong';
            }
            if ($order->problem != null){
                $order->status = 'Đơn rủi ro';
            }
        }
        // dd($orders);
        $breadCrumbs = [
            [
                'name' => 'Người dùng',
                'link' => '#',
            ],
            [
                'name' => 'Đơn hàng',
                'link' => '/user/orders',
            ]
        ];
        // dd(gettype($orders));
        return view('frontend.account.order',compact('breadCrumbs','orders'));
    }
    public function orderInfo($id){
        $order = Order::where('id',$id)->first();
        $order->created_at_converted = ConvertTimezone::convert_timezone($order->created_at);
        $order->status = 'Đơn đã được tạo';
        if ($order->confirmed_at != null){
            $order->confirmed_at = ConvertTimezone::convert_timezone($order->confirmed_at);
            $order->status = 'Đơn đã được xác nhận';
        }
        if ($order->start_deliver_at != null){
            $order->start_deliver_at = ConvertTimezone::convert_timezone($order->start_deliver_at);
            $order->status = 'Đơn đang được giao';
        } 
        if ($order->delivered_at != null){
            $order->delivered_at = ConvertTimezone::convert_timezone($order->delivered_at);
            $order->status = 'Đơn đã giao xong';
        }
        if ($order->problem != null){
            $order->status = 'Đơn rủi ro';
        }
        $order->ward = Ward::where('id',$order->ward_id)->first();
        $order->district = District::where('id',$order->ward->district_id)->first();
        $order->province = Province::where('id',$order->district->province_id)->first();
        $all_order = explode(',',$order->type);
        $details = array();
        foreach ($all_order as $one){
            $all = explode('-',$one);
            $type_id = $all[0];
            $type_info = Type::where('id',$type_id)->with('images')->first();
            $type_info->quantity = intval($all[2]);
            $type_info->size = intval($all[1]);
            array_push($details,$type_info);
        }
        $order->details = $details;
        $breadCrumbs = [
            [
                'name' => 'Người dùng',
                'link' => '#',
            ],
            [
                'name' => 'Đơn hàng',
                'link' => '/user/orders',
            ],
            [
                'name' => $order->id,
                'link' => '/user/orders/'.$order->id,
            ]
        ];
        return view('frontend.account.orderInfo',compact('breadCrumbs','order'));
    }
    public function deleteOrder(Request $request){
        if ($request->ajax()){
            $id = $request->input('id');
            $problem = $request->input('desc');
            Order::where('id',$id)->update([
                'deleted_at' => now(),
                'problem' => $problem,
            ]);
            session()->flash('success','Bạn đã hủy đơn hàng thành công');
            return response()->json([
                'result' => 'success'
            ]);
        }
    }
}
