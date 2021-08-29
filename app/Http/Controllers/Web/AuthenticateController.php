<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function showLoginForm(){
        return view('frontend.account.login');
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember') == 'on' ? True : False;
        
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)){
            return redirect('/dashboard');
        } else {
            $loginFailed = 'Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu của bạn';
            return view('frontend.account.login', compact('loginFailed'));
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/dashboard');
    }
}
