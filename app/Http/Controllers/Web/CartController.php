<?php

namespace App\Http\Controllers\Web;

use App\Events\MessageNotification;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;


class CartController extends Controller
{
    public function showCheckoutForm(){
            if (Auth::guard('web')->check()){
                $provinces = Province::all();
                $breadCrumbs = [
                    [
                        'name' => 'Giỏ hàng',
                        'link' => '/cart',
                        // 'link' => '#'
                    ],
                    [
                        'name' => 'Thanh toán',
                        'link' => 'cart/checkout',
                        // 'link' => '#'
                    ],
                ];
                return view('frontend.checkout',compact('breadCrumbs','provinces'));
            } else {
                session()->flash('fail', 'Vui lòng đăng nhập để thanh toán');
                return back();
            }
    }
    public function cart(){
        $breadCrumbs = [
            [
                'name' => 'Giỏ hàng',
                'link' => '/cart',
                // 'link' => '#'
            ],
        ];
        return view('frontend.cart',compact('breadCrumbs'));
    }
    public function getDistricts(Request $request){
        if( $request->ajax()){
            $province_id = $request->input('province_id');
            $districts = Province::findOrFail($province_id)->districts()->get();
            return json_encode($districts);
        }
    }
    public function getWards(Request $request){
        if( $request->ajax()){
            $district_id = $request->input('district_id');
            $wards = District::findOrFail($district_id)->wards()->get();
            return json_encode($wards);
        }
    }
    // php artisan vietnam-map:download
   
    // 0 Chưa thanh toán
    // 1 Đã thanh toán
    // 2 Thanh toán lỗi
    public function checkout(Request $request){
        // dd($request->input());
        if ($request->ajax()){
            $cart =json_decode($request->input('cart'));
            $type_cart = $request->input('type_cart');
            $ward = $request->input('ward');
            $detailsAddress = $request->input('detailsAddress');
            $array = array();
            foreach ($cart as $key => $value){
                array_push($array,$value->cart_id.'-'.$value->quantity);
            }
            $string = implode(',',$array);
            $result = Order::create([
                'type'=> $string,
                'payment_type' => $type_cart,
                'checkout_status' => 0,
                'user_id' => Auth::guard('web')->user()->id,
                'ward_id' => $ward,
                'details_address' => $detailsAddress,
                'is_read' => 'false',
                'created_at' => now(),
            ]);
            $order = Order::where('id',$result->id)->first();
            event(new MessageNotification($order,'Đơn hàng từ khách hàng: '.Auth::guard('web')->user()->name));
            session()->flash('success', 'Bạn đã đặt hàng thành công, vào tài khoản của bạn để xem chi tiết đơn hàng');
            return response()->json([
                'result' => 'success',
            ]);
        }
    }
}
