<?php

use App\Events\MessageNotification;
use App\Http\Controllers\Admin\SubcriberController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Web\AuthenticateController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\TypeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\LiveSearchController;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\SocialiteController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\VNPayController;
use App\Mail\SendPassword;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

    Route::group(['middleware'=> 'if-user-logged-return-back'], function(){ 
        Route::get('/login',[AuthenticateController::class, 'showLoginForm']);
        Route::post('/login',[AuthenticateController::class, 'login']);
        Route::get('/register',[AuthenticateController::class,'showRegisterForm']);
        Route::post('/register',[AuthenticateController::class,'register'] );
        Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
        Route::post('/forgotpassword',[AuthenticateController::class,'forgotPassword'] );
        Route::get('/createpassword/{token}',[AuthenticateController::class, 'showCreatePasswordWhenForgot']);
        Route::post('/createpassword/{token}',[AuthenticateController::class, 'createPasswordWhenForgot']);
        Route::post('/checkemailexists',[AuthenticateController::class,'checkEmailExists']);
        Route::get('/verifyemail/{token}',[AuthenticateController::class,'verifyEmail']);
        Route::get('/google',[SocialiteController::class,'redirectToGoogle']);
        Route::get('/google/callback',[SocialiteController::class,'handdleGoogleCallback']);
        Route::get('/github',[SocialiteController::class,'redirectToGithub']);
        Route::get('/github/callback',[SocialiteController::class,'handdleGithubCallback']);
        Route::get('/facebook', [SocialiteController::class, 'redirectToFacebook']);
        Route::get('/facebook/callback', [SocialiteController::class, 'handdleFacebookCallback']);
    });

    Route::group(['middleware'=> 'authisuser'], function(){ 
        Route::get('/logout',[AuthenticateController::class,'logout']);
        Route::get('/information',[UserController::class,'showInformation']);
        Route::post('/information',[UserController::class,'updateInformation']);
        Route::get('/changepassword',[AuthenticateController::class,'showChangePassword'])->middleware('notSocialiteUser');
        Route::post('/changepassword',[AuthenticateController::class,'changePassword'])->middleware('notSocialiteUser');
        Route::get('/createpassword',[AuthenticateController::class,'showCreatePassword'])->middleware('passwordIsNull');
        Route::post('/createpassword',[AuthenticateController::class,'createPassword'])->middleware('passwordIsNull');
        Route::get('/orders',[UserController::class,'orders']);
        Route::get('/orders/{id}',[UserController::class,'orderInfo']);
        Route::post('/orders/delete',[UserController::class,'deleteOrder']);
    });
});
Route::group(['middleware'=> 'authisuser'], function(){ 
    Route::post('/getdistricts',[CartController::class,'getDistricts']);
    Route::post('/getwards',[CartController::class,'getWards']);
    Route::get('cart/checkout/cod', [CartController::class, 'checkout']);
    Route::get('cart/checkout/online', [VNPayController::class, 'create']);
    Route::get('cart/return-vnpay', [VNPayController::class, 'return']);
    Route::get('cart/checkout', [CartController::class, 'showCheckoutForm'])->middleware('needPhoneNumber');
});

Route::get('/',[MainController::class,'home']);

Route::get('contact',[MainController::class,'contactView']);
Route::post('contact',[SupportController::class, 'store']);

Route::get("/categories/{category_id}",[CategoryController::class,'categoryView']);
Route::get("/categories/{category_id}/products/{product_id}",[ProductController::class,'productView']);
Route::get("/categories/{category_id}/products/{product_id}/types/{type_id}",[TypeController::class,'typeView']);
Route::get('products/{id}',[ProductController::class,'getUrl']);
Route::get('/types/{id}',[TypeController::class,'getUrl']);
Route::get('/types', [TypeController::class,'search']);

Route::post("/get-type-info",[TypeController::class,'getTypeInfo']);
Route::get('/search',[LiveSearchController::class,'search']);
Route::get('/subcriber',[SubcriberController::class,'subcriber']);
Route::post("products/quickshop",[ProductController::class,'quickShop']);
Route::post('products/getimages',[ProductController::class,'getImages']);
// cart
Route::get('cart', [CartController::class, 'cart']);
Route::post('add-to-cart', [CartController::class, 'addToCart']);
Route::post('update-cart', [CartController::class, 'update']);
Route::post('remove-from-cart', [CartController::class, 'remove']);


// Route::get('/event', function(){
//     // MessageNotification::dispatch('This is our first broadcasting message!');
//     $order = Order::where('id','1')->first();
//     event(new MessageNotification($order,'Đơn hàng từ khách hàng: '.Auth::guard('web')->user()->name));

// });
// Route::get('/listen', function () {
//     return view('listen');
// });