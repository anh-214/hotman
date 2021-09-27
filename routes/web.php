<?php

use App\Http\Controllers\Web\AuthenticateController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\SocialiteController;
use App\Mail\SendPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => '/user'],function () {

    Route::group(['middleware'=> 'userlogged'], function(){ 
        Route::get('/login',[AuthenticateController::class, 'showLoginForm']);
        Route::post('/login',[AuthenticateController::class, 'login']);
        Route::get('/register',[AuthenticateController::class,'showRegisterForm']);
        Route::post('/register',[AuthenticateController::class,'register'] );
        Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
        Route::post('/forgotpassword',[AuthenticateController::class,'forgotPassword'] );
        Route::post('/checkemailexists',[AuthenticateController::class,'checkEmailExists']);
        Route::get('/verifyemail/{token}',[AuthenticateController::class,'verifyEmail']);
        Route::get('/google',[SocialiteController::class,'redirectToGoogle']);
        Route::get('/google/callback',[SocialiteController::class,'handdleGoogleCallback']);
        Route::get('/github',[SocialiteController::class,'redirectToGithub']);
        Route::get('/github/callback',[SocialiteController::class,'handdleGithubCallback']);
    });

    Route::group(['middleware'=> 'authisuser'], function(){ 
        Route::get('/logout',[AuthenticateController::class,'logout']);
        Route::get('/information',[AccountController::class,'showInformation']);
        Route::post('/information',[AccountController::class,'updateInformation']);
        Route::get('/changepassword',[AuthenticateController::class,'showChangePassword'])->middleware('notSocialiteUser');
        Route::post('/changepassword',[AuthenticateController::class,'changePassword'])->middleware('notSocialiteUser');
        Route::post('/createpassword',[AuthenticateController::class,'createPassword'])->middleware('passwordIsNull');
    });
    
});

Route::get('contact', function () {
    $breadCrumbs = [
        [
            'name' => 'Contact',
            'link' => '/contact',
        ]
    ];
    return view('frontend.contact',compact('breadCrumbs'));
});
Route::get('/home', function(){
    if (Auth::guard('web')->check()){
        die(Auth::guard('web')->user()->name);
    }
});
Route::get('/mail', function () {
    $email = '123';
    $password = 'abc';
    return view('mail.sendPassword',['email'=> $email,'password'=> $password]);
});
Route::get('/sent', function () {
    
        $email = 'tuananh1x2@gmail.com';
        $password = 'abc';
        return Mail::to($email)->send(new SendPassword($email,$password));
    

    
});