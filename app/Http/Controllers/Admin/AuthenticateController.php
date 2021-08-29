<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
