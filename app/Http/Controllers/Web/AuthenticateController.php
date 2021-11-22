<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\EmailResetPassword;
use App\Mail\SendPassword;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
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
            session()->flash('success', 'Đăng nhập thành công');
                return redirect('/');
            }
        } else {
            session()->flash('fail', 'Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu của bạn');
            return view('frontend.account.login');
        }
    }
    public function logout(){
        Auth::guard('web')->logout();
        return redirect('user/login');
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
        Mail::to($request->input('email'))->send(new VerifyEmail($request->input('email'),$token));
        session()->flash('success', 'Đăng ký tài khoản thành công, vui lòng xác nhận email của bạn');
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
                'link' => '#',
            ],
            [
                'name' => 'Change Password',
                'link' => '/user/changepassword',
            ]
        ];
        return view('frontend.account.changepassword',compact('breadCrumbs'));
    }
    public function changePassword(Request $request){
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
            session()->flash('success','Đổi mật khẩu thành công');
        } else {
            session()->flash('fail','Đổi mật khẩu thất bại, vui lòng kiểm tra lại mật khẩu cũ');
        }
        return back();
    }
    public function verifyEmail($token){
        $check = DB::table('verify_email')->where('token',$token)->first();
        if ($check != null){
            User::where('email',$check->email)->update([
                'email_verified_at' => now()
            ]);

            session()->flash('success','Xác nhận email thành công');
            return redirect('user/login');
        }
    }
   
    public function showForgotPasswordForm(){
        return view('frontend.account.forgotPassword');
    }
    public function forgotPassword (Request $request){
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
            $link = url('user/createpassword/'.$token);
            Mail::to($request->input('email'))->send(new EmailResetPassword($request->input('email'),$link));
            session()->flash('success','Vui lòng kiểm tra email của bạn để lấy mật khẩu');
            return back();

        } else {
            session()->flash('fail','Email này chưa được đăng ký');
            return back();
        }
    }
    // create password when forgotpassword
    public function showCreatePasswordWhenForgot($token){
        $token = DB::table('password_resets')->where('token',$token)->first();
        if ($token == null ){
            session()->flash('fail','Sai token');
            return redirect('user/login');
        } else {
            $token_latest = DB::table('password_resets')->where('email',$token->email)->latest()->first()->token;
            if ($token_latest == $token->token){
                if (Carbon::parse($token->created_at) < Carbon::yesterday()) {
                    session()->flash('fail','Token đã hết hạn');
                    return redirect('user/login');
                }
                return view('frontend.account.createPasswordForgot',['token' => $token->token,'email' => $token->email]);
            } else {
                session()->flash('fail','Token đã được sử dụng');
                return redirect('user/login');
            }
        }
        
    }
    public function createPasswordWhenForgot(Request $request,$token){
            $password = $request->input('password');
            $token = DB::table('password_resets')->where('token',$token)->first();
            // $token_latest = DB::table('password_resets')->where('email',$token->email)->latest()->first()->token;
            // if ($token_latest == $token->token){
            if ($token == null) {
                session()->flash('fail','Tạo mật khẩu thất bại');
                return redirect('user/login');
            } else {
                User::where('email', $token->email)->update([
                    'password' => Hash::make($password),
                    'password_is_null' => 'False'
                ]);
                DB::table('password_resets')->where('token',$token->token)->delete();
                
                if (Auth::guard('web')->attempt(['email' => $token->email, 'password' => $password])){
                    session()->flash('success','Đăng nhập thành công');
                    return redirect('/');
                }
            }
                // session()->flash('success','Tạo mật khẩu mới thành công');
                // return redirect('user/login');
            // } else {
                // session()->flash('fail','Tạo mật khẩu thất bại');
                // return redirect('user/login');
            // }
        
    }
    // create password when login with socialite
    public function showCreatePassword(){
        $breadCrumbs = [
            [
                'name' => 'User',
                'link' => '#',
            ],
            [
                'name' => 'Information',
                'link' => '/user/information',
            ]
        ];
        return view('frontend.account.createPassword',compact('breadCrumbs')); 
    }
    public function createPassword(Request $request){

        $password = $request->input('password');
        User::where('id',Auth::guard('web')->user()->id)->update([
            'password' => Hash::make($password),
            'password_is_null' => 'False'
        ]);
        session()->flash('success', 'Tạo mật khẩu thành công, tiến hành đăng nhập lại');
        Auth::guard('web')->logout();
        return redirect('user/login');
            
    }
}
