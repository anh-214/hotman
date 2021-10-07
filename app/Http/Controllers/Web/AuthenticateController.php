<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendPassword;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\verifyEmail;
use Illuminate\Support\Facades\Password;

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
        
        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password], $remember)){
            if (Auth::guard('web')->user()->email_verified_at == Null) {
                Auth::guard('web')->logout();
                $loginFailed = 'Vui lòng xác nhận email trước khi đăng nhập';
                return view('frontend.account.login', compact('loginFailed'));
            } else {
                return redirect('/home');
            }
        } else {
            $loginFailed = 'Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu của bạn';
            return view('frontend.account.login', compact('loginFailed'));
        }
    }
    public function logout(){
        Auth::guard('web')->logout();
        
        return back();
    }
    public function showRegisterForm(){
        return view('frontend.account.register');
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email',
            'phonenumber' => 'required',
            'password' => 'required',
        ]);
        User::create($request->input());
        User::where('email',$request->input('email'))->update([
                'password_is_null' => 'False',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(60),
        ]);
        $token = Str::random(20);
        DB::table('verify_email')->insert([
            'email' => $request->input('email'),
            'token' => $token,
            'created_at' => now(),
        ]);
        Mail::to($request->input('email'))->send(new verifyEmail($request->input('email'),$token));
        session()->put('result', 'success');
        return back();
    }
    public function checkEmailExists(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => 'exists',
            ]);
        } else {
            return response()->json([
                'result' => 'notExists',
            ]);
        }
    }
    public function showChangePassword(){
        $breadCrumbs = [
            [
                'name' => 'User',
                'link' => '/user',
            ],
            [
                'name' => 'Change Password',
                'link' => '/user/changepassword',
            ]
        ];
        return view('frontend.account.changepassword',compact('breadCrumbs'));
    }
    public function changePassword(Request $request){
        $breadCrumbs = [
            [
                'name' => 'User',
                'link' => '/user',
            ],
            [
                'name' => 'Change Password',
                'link' => '/user/changepassword',
            ]
        ];

        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required',
        ]);
        $oldPassword = $request->input('oldpassword');
        $password = $request->input('password');
        if (Hash::check($oldPassword, Auth::guard('web')->user()->password)){
            User::where('id', Auth::guard('web')->user()->id)->update([
                'password' => Hash::make($password)
            ]);
            $result = True;
            return view('frontend.account.changepassword',compact(['breadCrumbs','result']));
        } else {
            $result = False;
            return view('frontend.account.changepassword',compact(['breadCrumbs','result']));
        }
        
    }
    public function verifyEmail($token){
        $check = DB::table('verify_email')->where('token',$token)->first();
        if ($check != null){
            User::where('email',$check->email)->update([
                'email_verified_at' => now()
            ]);
            session()->put('verifyEmail', 'success');
            return redirect('user/login');
        }
    }
    public function createPassword(Request $request){
        if( $request->ajax()){
            $email = $request->input('email');
            $password = Str::random(10);
            User::where('email',$email)->update([
                'password' => Hash::make($password),
                'password_is_null' => 'False'
            ]);
            Mail::to($email)->send(new SendPassword($email,$password));
            Auth::guard('web')->logout();
            return response()->json([
                'result' => 'sent'
            ]);
        }
    }
    public function showForgotPasswordForm(){
        return view('frontend.account.forgotPassword');
    }
    public function forgotPassword (Request $request){
        $email = $request->input('email');
        $password = Str::random(10);
        User::where('email',$email)->update([
            'password' => Hash::make($password),
            'password_is_null' => 'False'
        ]);
        Mail::to($email)->send(new SendPassword($email,$password));
        session()->flash('createPassword', 'success');
        return back();
    }

    //public function forgotPassword (Request $request){
    //     $request->validate(['email' => 'required|email']);
        
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );
    //     return $status === Password::RESET_LINK_SENT
    //     ? back()->with(['status' => __($status)])
    //     : back()->withErrors(['email' => __($status)]);
    
    // }
}
