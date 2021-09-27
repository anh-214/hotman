<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TypeController;
use App\Mail\EmailResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Whoops\Run;

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
Route::group(['prefix' => '/admin'],function () {

    Route::group(['middleware'=> 'authisadmin'], function(){
        Route::get('/dashboard',[MainController::class,'dashboard'])->name('dashboard');
        Route::get('/logout',[AuthenticateController::class,'logout']);

        Route::get('/manager',[MainController::class,'manager']);
        Route::post('manager/delete',[AccountController::class,'delete']);
        Route::post('manager/update',[AccountController::class,'update']);
        Route::post('manager/create',[AccountController::class,'create']);
        Route::post('manager/checkemailexists',[AccountController::class,'checkEmailExists']);

        Route::get('/profile',[MainController::class,'profile']);
        Route::post('/profile/changepassword',[AccountController::class,'changePassword']);
        Route::post('/profile/update',[AccountController::class,'update']);
        
        Route::get('/categories',[MainController::class,'categories']);
        Route::post('/categories/create',[CategoryController::class,'create']);
        Route::post('/categories/delete',[CategoryController::class,'delete']);
        Route::post('/categories/update',[CategoryController::class,'update']);

        Route::get('/products',[MainController::class,'products']);
        Route::post('/products/create',[ProductController::class,'create']);
        Route::post('/products/delete',[ProductController::class,'delete']);
        Route::post('/products/update',[ProductController::class,'update']);

        Route::get('/types',[MainController::class,'types']);
        Route::get('/types/create',[TypeController::class,'showCreateForm']);
        Route::post('/types/create',[TypeController::class,'create']);
        Route::get('/types/update',[TypeController::class,'showUpdateForm']);
        Route::post('/types/update',[TypeController::class,'update']);
        Route::post('/types/upload',[TypeController::class,'upload']);
        Route::post('/types/delete',[TypeController::class,'delete']);
        Route::post('/types/getImages',[TypeController::class,'getImages']);
        Route::post('/types/getProductId',[TypeController::class,'getProductId']);

        Route::get('/importcsv',[TypeController::class,'showImportCsvForm']);
        Route::post('/importcsv',[TypeController::class,'importCsv']);
        
    });
    Route::get('/login', [AuthenticateController::class,'showLoginForm'])->middleware('adminlogged');
    Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
    Route::post('/forgotpassword',[AuthenticateController::class,'forgotPassword']);
    Route::get('/createpassword/{token}',[AuthenticateController::class, 'verifyTokenCreatePassword']);
    Route::post('/createpassword',[AuthenticateController::class, 'createPassword']);
    Route::post('/login', [AuthenticateController::class,'login']);
    // Route::get('/mail', function(){
    //     return view('mail.index',['email'=> 'tuananh1x2@gmail.com','token' => '123']);
    // });
});
