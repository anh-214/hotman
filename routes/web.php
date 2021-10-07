<?php

use App\Http\Controllers\Web\AuthenticateController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\TypeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\MainController;
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

Route::get('contact',[MainController::class,'contactView']);
Route::get('home',[MainController::class,'home']);
Route::get("/category/{category_id}",[CategoryController::class,'categoryView']);
Route::get("/category/{category_id}/product/{product_id}",[ProductController::class,'productView']);
Route::get("/category/{category_id}/product/{product_id}/type/{type_id}",[TypeController::class,'typeView']);

Route::post("product/quickshop",[ProductController::class,'quickShop']);
Route::post('product/getimages',[ProductController::class,'getImages']);

// cart
Route::get('cart', [CartController::class, 'cart']);
Route::post('add-to-cart', [CartController::class, 'addToCart']);
Route::post('update-cart', [CartController::class, 'update']);
Route::post('remove-from-cart', [CartController::class, 'remove']);
Route::get('cart/checkout', [CartController::class, 'showCheckoutForm']);

Route::group(['middleware'=> 'authisuser'], function(){ 
    Route::post('/getdistricts',[CartController::class,'getDistricts']);
    Route::post('/getwards',[CartController::class,'getWards']);
    Route::post('cart/checkout', [CartController::class, 'checkout']);
    Route::get('cart/checkout', [CartController::class, 'showCheckoutForm']);
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