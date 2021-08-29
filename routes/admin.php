<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\DashboardController;
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
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
        Route::get('/logout',[AuthenticateController::class,'logout']);
        Route::get('/manager',[AccountController::class,'index']);
        Route::post('manager/delete',[AccountController::class,'delete']);
        Route::post('manager/update',[AccountController::class,'update']);
        Route::post('manager/create',[AccountController::class,'create']);
        Route::post('manager/checkemailexists',[AccountController::class,'checkEmailExists']);
        Route::get('/profile',[AccountController::class,'profile']);
        Route::post('/profile/update',[AccountController::class,'updateProfile']);
        
    });
    Route::get('/login', [AuthenticateController::class,'showLoginForm'])->middleware('logged');
    Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
    Route::post('/login', [AuthenticateController::class,'login']);
});
