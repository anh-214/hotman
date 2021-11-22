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
        $select = 'Quản lí khuyến mại';
        $active = 'promotion';
        $promotions = Promotion::with('types')->orderBy('position','asc')->get();
        return view('backend.promotion.promotion',compact('select','active','promotions'));
    }
    public function info($id){
        $select = 'Chi tiết khuyến mại';
        $active = 'promotion';
        $promotion = Promotion::where('id',$id)->first();
        return view('backend.promotion.promotionInfo',compact('select','active','promotion'));
    }
    public function create(Request $request){
        $request->validate([
            'createName' => 'required',
            'createDiscount' => 'required',
            'createShow' => 'required'
        ]);
        $latest = Promotion::orderBy('position','desc')->first();
        if ($latest == null){
            Promotion::create([
                'name' => $request->input('createName'),
                'discount' => $request->input('createDiscount'),
                'position' => 1,
                'show' => $request->input('createShow'),
            ]);
        } else {
            Promotion::create([
                'name' => $request->input('createName'),
                'discount' => $request->input('createDiscount'),
                'position' => $latest->position+1,
                'show' => $request->input('createShow'),
            ]);
        }
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
    public function delete(Request $request,$id){
        $password = $request->input('password');
        if (Hash::check($password, Auth::guard('admin')->user()->password)){
            $types = Type::where('promotion_id',$id)->get();
            foreach ($types as $type){
                Type::where('id',$type->id)->update([
                    'promotion_id' => null,
                    'price' => $type->initial_price
                ]);
            }
            $current = Promotion::where('id',$id)->first();
            $changes = Promotion::where('position','>',$current->position)->get();
            Promotion::where('id',$id)->delete();
            foreach ($changes as $change){
                Promotion::where('id',$change->id)->update([
                    'position' => $change->position-1
                ]);
            }
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
    public function update(Request $request,$id){
        $request->validate([
            'updateName' => 'required',
            'updateDiscount' => 'required',
            'updateShow' => 'required'
        ]);
        Promotion::where('id',$id)->update([
            'name' => $request->input('updateName'),
            'discount' => $request->input('updateDiscount'),
            'show' => $request->input('updateShow')
        ]);
        $types = Type::where('promotion_id',$id)->get();
            foreach ($types as $type){
                $price = ($type->initial_price - ($type->initial_price*(intval($request->input('updateDiscount'))/100)));
                Type::where('id',$type->id)->update([
                    'price' => $price
                ]);
            }
        session()->flash('success','Cập nhật khuyến mại thành công');
        return response()->json([
            'result' => 'success'
        ]);
    }
    public function up($id){
        $down = Promotion::where('id',$id)->first();
        if ($down->position != '1'){
            $up = Promotion::where('position',$down->position-1)->first();
            if ($up != null){
                Promotion::where('id',$up->id)->update([
                    'position' => $down->position
                ]);
                Promotion::where('id',$down->id)->update([
                    'position' => $down->position-1
                ]);
                session()->flash('success','Di chuyển khuyến mại thành công');
                return back();
            } else {
                Promotion::where('id',$down->id)->update([
                    'position' => $down->position-1
                ]);
                return back();
            }
        } else {
            return back();
        }
    }
    public function down($id){
        $up = Promotion::where('id',$id)->first();
        if ($up->position != Promotion::orderBy('position','desc')->first()->position){
            $down = Promotion::where('position',$up->position+1)->first();
            Promotion::where('id',$down->id)->update([
                'position' => $up->position
            ]);
            Promotion::where('id',$up->id)->update([
                'position' => $up->position+1
            ]);
            session()->flash('success','Di chuyển khuyến mại thành công');
            return back();
        } else {
            return back();
        }
    }
}

