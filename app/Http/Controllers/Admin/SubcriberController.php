<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewEmail;
use App\Models\Subcriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class SubcriberController extends Controller
{
    public function subcriber(Request $request){
        $validator = Validator::make($request->all(), [
            'subcriberEmail' => 'unique:subcribers,email',
        ]);
        if ($validator->fails()) {
            session()->flash('fail','Email đã được đăng ký nhận tin trước đây');
        } else {
            Subcriber::insert([
                'email' => $request->input('subcriberEmail'),
                'created_at' => now()
            ]);
            session()->flash('success','Đăng ký nhận tin thành công');
        }  
        return back();
    }
    public function index(){
        $select = 'Quản lý khách hàng đăng ký nhận tin';
        $active = 'subcriber';
        $subcribers = Subcriber::orderBy('created_at','desc')->paginate(15);
        return view('backend.subcriber.subcriber',compact('active','select','subcribers'));
    }
    public function newEmail(){
        $select = 'Thêm tin mới';
        $active = 'subcriber';
        return view('backend.subcriber.newEmail',compact('active','select'));
    }
    public function action(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');
        $content = str_replace('src="../..','src="'.url(''),$content);
        // dd($content);
        if ($request->input('action') == 'preview'){
            return view('mail.previewEmail',compact('content'));
        } elseif ($request->input('action') == 'confirm'){
            $subcribers = Subcriber::all('email');
            // dd($subcribers);
            foreach ($subcribers as $subcriber){
                Mail::to($subcriber->email)->send(new NewEmail($title,$content));
            }
            session()->flash('success', 'Gửi thư thành công');
            return redirect('admin/subcribers');
        }
    }   
    public function delete($id){
        Subcriber::where('id',$id)->delete();
        session()->flash('success','Xóa người đăng ký thành công');
        return back();
    }
}
