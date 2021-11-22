<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailResetPassword;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class AuthenticateController extends Controller
{
    public function showLoginForm(){
        return view('backend.account.login');
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember') == 'on' ? True : False;
        
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)){
            session()->flash('success','Đăng nhập thành công');
            return redirect('admin/dashboard');
        } else {
            session()->flash('fail','Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu của bạn');
            return view('backend.account.login');
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
    public function showForgotPasswordForm(){
        return view('backend.account.forgotPasswordForm');
    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'unique:admins,email',
        ]);
        if ($validator->fails()) {
            $token = Str::random(20);
            DB::table('password_resets')->insert([
                'token' => $token,
                'email' => $request->input('email'),
                'created_at' => now(),
            ]);
            $link = url('admin/createpassword/'.$token);
            Mail::to($request->input('email'))->send(new EmailResetPassword($request->input('email'),$link));
            // return response()->json([
            //     'result' => 'exists',
            // ]);
            session()->flash('success','Vui lòng kiểm tra email của bạn để lấy mật khẩu');
            return back();

        } else {
            // return response()->json([
            //     'result' => 'notExists',
            // ]);
            session()->flash('fail','Email này chưa được đăng ký');
            return back();
        }
    }

    public function showCreatePassword($token){
        $token = DB::table('password_resets')->where('token',$token)->first();
        if ($token == null ){
            session()->flash('fail','Sai token');
            return redirect('admin/login');
        } else {
            $token_latest = DB::table('password_resets')->where('email',$token->email)->latest()->first()->token;
            if ($token_latest == $token->token){
                if (Carbon::parse($token->created_at) < Carbon::yesterday()) {
                    session()->flash('fail','Token đã hết hạn');
                    return redirect('admin/login');
                }
                return view('backend.account.createPassword',['token' => $token->token,'email' => $token->email]);
            } else {
                session()->flash('fail','Token đã được sử dụng');
                return redirect('admin/login');
            }
        }
        
    }

    public function createPassword(Request $request,$token){
            $password = $request->input('password');
            $token = DB::table('password_resets')->where('token',$token)->first();
            if ($token == null) {
                session()->flash('fail','Tạo mật khẩu thất bại');
                return redirect('admin/login');
            } else {
                Admin::where('email', $token->email)->update([
                    'password' => Hash::make($password)
                ]);
                DB::table('password_resets')->where('token',$token->token)->delete();
                if (Auth::guard('admin')->attempt(['email' => $token->email, 'password' => $password])){
                    session()->flash('success','Đăng nhập thành công');
                    return redirect('admin/dashboard');
                }

                // session()->flash('success','Tạo mật khẩu mới thành công');
                // return redirect('admin/dashboard');
            }
            // $token_latest = DB::table('password_resets')->where('email',$token->email)->latest()->first()->token;
            // if ($token_latest == $token->token){

            // if (Carbon::parse($token->created_at) < Carbon::yesterday()) {
            //     session()->flash('fail','Token đã hết hạn');
            //     return redirect('admin/login');
            // }
            
                
            // } else {
                
            // }
        
    }
}
