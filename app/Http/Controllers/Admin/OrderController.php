<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Type;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;

class ConvertTimezone
{
    public static function convert_timezone($original_time){
        $datetime = new DateTime($original_time);
        $vi = new DateTimeZone('Asia/Ho_Chi_Minh');
        $datetime->setTimezone($vi);
        return $datetime->format('H:i  d/m/Y');
    }
}
class OrderController extends Controller
{
    public function orders($from = '',$to = ''){
        $select = 'Quản lí đơn hàng';
        $active = 'orders';
        $displayTime = '';
        if ($from == '' && $to == ''){
            $orders = Order::with('user')->orderBy('created_at','desc')->get();
        } else {
            $orders = Order::with('user')->whereBetween('created_at', [$from, $to])->orderBy('created_at','desc')->get();
            $from1 = Carbon::parse($from);
            $to1 = Carbon::parse($to);
            if ($from1->diffInDays($to1) == 1){
                $displayTime = $from1->format('d/m/Y');
            } else {
                $displayTime = $from1->format('d/m/Y').' - '.$to1->format('d/m/Y');
            }
        }
        $total_all = 0;
        $total_real = 0;
        $count_orders = 0;
        $count_problems = 0;
        foreach ($orders as $order){
            $order->created_at_converted = ConvertTimezone::convert_timezone($order->created_at);
            $all_order = explode(',',$order->type);
            $total_one = 0;
            foreach ($all_order as $one){
                $all = explode('-',$one);
                $array = array();
                $type_id = $all[0];
                $type_info = Type::where('id',$type_id)->with('images')->first();
                $quantity = intval($all[2]);
                $total_one += $quantity*intval($type_info->price);
            }
            $order->total = $total_one;
            
            if ($order->problem != null){
                $count_problems += 1;
            } else {
                $total_all += $total_one;
            }
            if ($order->delivered_at != null){
                $total_real += $total_one;
            }
            $count_orders += 1;

        }
        return view('backend.order.order',compact('select','active','orders','from','to','displayTime','total_all','total_real','count_orders','count_problems'));
    }
    public function orderInfo($id){
        $order = Order::where('id',$id)->with(['user'])->first();
        Order::where('id',$id)->update([
            'is_read' => 'true'
        ]);
        $select = 'Chi tiết đơn hàng';
        $active = 'orders';
        // dd($order->confirmed_at);
        $order->created_at_converted = ConvertTimezone::convert_timezone($order->created_at);

        if ($order->confirmed_at != null){
            $order->confirmed_at = ConvertTimezone::convert_timezone($order->confirmed_at);
        } 
        if ($order->start_deliver_at != null){
            $order->start_deliver_at = ConvertTimezone::convert_timezone($order->start_deliver_at);
        }
        if ($order->delivered_at != null){
            $order->delivered_at = ConvertTimezone::convert_timezone($order->delivered_at);
        }   
        if ($order->deleted_at != null){
            $order->deleted_at = ConvertTimezone::convert_timezone($order->deleted_at);
        }   
        $order->ward = Ward::where('id',$order->ward_id)->first();
        $order->district = District::where('id',$order->ward->district_id)->first();
        $order->province = Province::where('id',$order->district->province_id)->first();
        
        $all_order = explode(',',$order->type);
        $details = array();
        foreach ($all_order as $one){
            $all = explode('-',$one);
            $array = array();
            $type_id = $all[0];
            $type_info = Type::where('id',$type_id)->with('images')->first();
            $type_info->quantity = intval($all[2]);
            $type_info->size = intval($all[1]);
            array_push($details,$type_info);
        }
        $order->details = $details;
        return view('backend.order.orderInfo',compact('select','active','order'));
    }
    public function confirm(Request $request,$id){
        if ($request->ajax()){
            if (Order::where('id',$id)->first()->delivered_at == null){
                Order::where('id',$id)->update([
                    'confirmed_at' => now(),
                ]);
                // dd('ahihi');
                session()->flash('success', 'Xác nhận đơn hàng thành công');
                return response()->json([
                    'result' => 'success',
                ]);
            } else {
                session()->flash('fail', 'Lỗi');
                return response()->json([
                    'result' => 'success',
                ]);
            }
        }
    }
    public function unConfirm(Request $request,$id){
        if ($request->ajax()){
            if (Order::where('id',$id)->first()->delivered_at == null){
            Order::where('id',$id)->update([
                'confirmed_at' => null,
            ]);
            // dd('ahihi');
            session()->flash('fail', 'Hủy xác nhận đơn hàng');
            return response()->json([
                'result' => 'success',
            ]);
            } else {
                session()->flash('fail', 'Lỗi');
                return response()->json([
                    'result' => 'success',
                ]);
            }
        }
    }
    public function start_deliver(Request $request,$id){
        if ($request->ajax()){
            Order::where('id',$id)->update([
                'start_deliver_at' => now(),
            ]);
            // dd('ahihi');
            session()->flash('success', 'Xác nhận giao đơn hàng cho bên vận chuyển thành công');
            return response()->json([
                'result' => 'success',
            ]);
        }
    }
    public function delivered(Request $request,$id){
        if ($request->ajax()){
            Order::where('id',$id)->update([
                'checkout_status' => 1,
                'delivered_at' => now(),
            ]);
            // dd('ahihi');
            session()->flash('success', 'Xác nhận giao đơn hàng cho khách thành công');
            return response()->json([
                'result' => 'success',
            ]);
        }
    }
    public function problem(Request $request,$id){
        if ($request->ajax()){
            Order::where('id',$id)->update([
                'problem' => $request->input('problem'),
            ]);
            // dd('ahihi');
            session()->flash('success', 'Đã xác nhận rủi ro của đơn hàng');
            return response()->json([
                'result' => 'success',
            ]);
        }
    }
    public function getOrdersAjax(){

    }
}
