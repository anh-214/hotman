<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
class SocialiteController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handdleGoogleCallback(){
        $user = Socialite::driver('google')->user();
        $check = User::where('email',$user->email)->first();
        if ($check != null){
            if ($check->google_id != null){ 
                $login = User::where('google_id',$user->id)->first();
                Auth::guard('web')->login($login);
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('/home');
            } else {
                User::where('email',$user->email)->update([
                    'google_id' => $user->id,
                ]);
                $login = User::where('google_id',$user->id)->first();
                Auth::guard('web')->login($login);
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('/home');
            }
        } else {
            User::create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            User::where('email',$user->email)->update([
                'avatar' => $user->avatar,
                'google_id' => $user->id,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'password_is_null' => 'True',
                'remember_token' => Str::random(60),
            
            ]);
            $login = User::where('google_id',$user->id)->first();
            Auth::guard('web')->login($login);
            session()->flash('success', 'Đăng ký thành công');
            return redirect('/home');
            
        }
    }

    // github
    public function redirectToGithub(){
        return Socialite::driver('github')->redirect();
    }
    public function handdleGithubCallback(){
        $user = Socialite::driver('github')->user();
        $check = User::where('email',$user->email)->first();
        if ($check != null){
            if ($check->github_id != null){ 
                $login = User::where('github_id',$user->id)->first();
                Auth::guard('web')->login($login);
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('/home');
            } else {
                User::where('email',$user->email)->update([
                    'github_id' => $user->id,
                ]);
                $login = User::where('github_id',$user->id)->first();
                Auth::guard('web')->login($login);
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('/home');
            }
        } else {

            User::create([
                'name' => $user->nickname,
                'email' => $user->email,
            ]);
            User::where('email',$user->email)->update([
                'avatar' => $user->avatar,
                'github_id' => $user->id,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'password_is_null' => 'True',
                'remember_token' => Str::random(60),
            
            ]);
            $login = User::where('github_id',$user->id)->first();
            Auth::guard('web')->login($login);
            session()->flash('success', 'Đăng ký thành công');
            return redirect('/home');
            
        }
    }
}
