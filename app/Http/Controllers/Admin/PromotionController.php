<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PromotionController extends Controller
{
    public function index(){
        $select = 'Promotion';
        $active = 'promotion';
        $promotions = Promotion::with('types')->get();
        return view('backend.main.promotion',compact('select','active','promotions'));
    }
    public function create(Request $request){
        $request->validate([
            'createName' => 'required',
            'createDiscount' => 'required'
        ]);
        Promotion::create([
            'name' => $request->input('createName'),
            'discount' => $request->input('createDiscount'),
        ]);
        session()->flash('success','Tạo chương trình khuyến mại thành công');
        return back();
    }
    public function deleteType(Request $request){
        $type = Type::where('id',$request->input('id'))->first();
        Type::where('id',$request->input('id'))->update([
            'promotion_id' => null,
            'price' => $type->initial_price
        ]);
        session()->flash('success','Xóa loại sản phẩm khỏi chương trình khuyến mại thành công');
        return response()->json([
            'result'=>'success'
        ]);
    }
    public function delete(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            $types = Type::where('promotion_id',$id)->get();
            foreach ($types as $type){
                Type::where('id',$type->id)->update([
                    'promotion_id' => null,
                    'price' => $type->initial_price
                ]);
            }
            Promotion::where('id',$id)->delete();
            session()->flash('success','Xóa khuyến mại thành công');
            return response()->json([
                'result' => 'success'
            ]);
        } else {
            session()->flash('fail','Xóa khuyến mại thất bại, vui lòng kiểm tra lại mật khẩu');
            return response()->json([
                'result' => 'failed'
            ]);
        }
    }
    public function update(Request $request){
        $request->validate([
            'updateId' => 'required',
            'updateName' => 'required',
            'updateDiscount' => 'required',
        ]);
        Promotion::where('id',$request->input('updateId'))->update([
            'name' => $request->input('updateName'),
            'discount' => $request->input('updateDiscount'),
        ]);
        $types = Type::where('promotion_id',$request->input('updateId'))->get();
            foreach ($types as $type){
                $price = ($type->initial_price - ($type->initial_price*(intval($request->input('updateDiscount'))/100)));
                Type::where('id',$type->id)->update([
                    'price' => $price
                ]);
            }
        session()->flash('success','Cập nhật khuyến mại thành công');
        return back();
    }
}

