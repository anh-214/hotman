<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailResetPassword;
use App\Models\Admin;
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
            return redirect('admin/dashboard');
        } else {
            $loginFailed = 'Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu của bạn';
            return view('backend.account.login', compact('loginFailed'));
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
                'email' => $request->input('email'),
                'token' => $token,
                'created_at' => now(),
            ]);
            Mail::to($request->input('email'))->send(new EmailResetPassword($request->input('email'),$token));
            return response()->json([
                'result' => 'exists',
            ]);
        } else {
            return response()->json([
                'result' => 'notExists',
            ]);
        }
    }

    public function verifyTokenCreatePassword($token){
        $admin = DB::table('password_resets')->where('token',$token)->first();
        if ($admin == null ){
            return back();
        } else {
            return view('backend.account.createPassword',['token' => $token,'email'=> $admin->email]);
        }
        
    }

    public function createPassword(Request $request){
        if( $request->ajax()){
            $password = $request->input('password');
            $email = $request->input('email');
            $token = $request->input('token');

            $admin = DB::table('password_resets')->where('token',$token)->first();
            if ($admin->email == $email ){
                Admin::where('email', $email)->update([
                    'password' => Hash::make($password)
                ]);
                return response()->json([
                    'result' => 'success'
                ]);
            } else {
                return response()->json([
                    'result' => 'failed'
                ]);
            }
        }
    }
}
