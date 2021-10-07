<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {   
        $type = Type::findOrFail($request->id);
        $product_id_cart = \App\Models\Type::where('id',$request->id)->first()->product_id;
		$category_id_cart = \App\Models\Product::where('id',$product_id_cart)->first()->category_id;
        if (filter_var($type->images[0]->name, FILTER_VALIDATE_URL)) { 
            $image = $type->images[0]->name;
        } else {
            $image = Storage::disk('type-image')->url($type->images[0]->name);
        }   
        $cart = session()->get('cart', []);
        if(isset($cart[$request->input('id').'-'.$request->input('size')])) {
            $cart[$request->input('id').'-'.$request->input('size')]['quantity'] += $request->input('quantity');
        } else {
            $cart[$request->id.'-'.$request->size] = [
                'id' => $request->id,
                'link' => url('category/'.$category_id_cart.'/product/'.$product_id_cart.'/type/'.$type->id),
                "name" => $type->name,
                "quantity" => $request->quantity,
                "size" => $request->size,
                "price" => $type->price == 0 ? $type->initial_price: $type->price,
                "image" => $image
            ];
        }
        session()->put('cart', $cart);
        session()->flash('success', 'Thêm sản phẩm thành công');
        return response()->json([
            'result' => 'success'
        ]);
    }
    public function update(Request $request)
    {   
        if ($request->ajax()){ 
            if($request->id && $request->quantity){
                $cart = session()->get('cart');
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                return response()->json([
                    'result' => 'success'
                ]);
                // session()->flash('success', 'Cart updated successfully');
            }
        }
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Xóa sản phẩm thành công');
            return response()->json([
                'result' => 'success'
            ]);
        }
    }
    public function showCheckoutForm(){
        $cart = session()->get('cart', []);
        if($cart == []) {
            session()->flash('fail', 'Giỏ hàng trống, hãy thêm sản phẩm');
            return back();
        } else {
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
                return view('frontend.checkout',compact('breadCrumbs','provinces','cart'));
            } else {
                session()->flash('fail', 'Vui lòng đăng nhập để thanh toán');
                return back();
            }
        }
    }
    public function cart(){
        $cart = session()->get('cart', []);
        $breadCrumbs = [
            [
                'name' => 'Giỏ hàng',
                'link' => '/cart',
                // 'link' => '#'
            ],
        ];
        return view('frontend.cart',compact('breadCrumbs','cart'));
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
    public function checkout(Request $request){
        dd($request->input());
    }
}
