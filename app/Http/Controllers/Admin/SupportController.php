<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function index(){
        $select = 'Hỗ trợ khách hàng';
        $active = 'support';
        $supports = Support::orderBy('created_at','desc')->paginate(15);
        return view('backend.support.support',compact('active','select','supports'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phonenumber' => 'required',
            'content' => 'required',
        ]);
        Support::insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phonenumber' => $request->input('phonenumber'),
            'content' => $request->input('content'),
            'status' => 'false',
            'created_at' => now(),
        ]);
        session()->flash('success','Gửi liên hệ thành công');
        return back();
    }
    public function details($id){
        $support = Support::where('id',$id)->first();
        $select = 'Hỗ trợ khách hàng';
        $active = 'support';
        return view('backend.support.supportDetails',compact('active','select','support'));
    }
    public function reply(Request $request,$id){
        DB::table('supports')->where('id',$id)->update([
            'status' => $request->input('status'),
        ]);
        session()->flash('success','Cập nhật hỗ trợ khách hàng thành công');
        return redirect('admin/supports');
    }
}
