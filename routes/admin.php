<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSortController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PromotionController;
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
        Route::group(['middleware'=> 'adminisrole1'], function(){
            Route::get('/manager',[ManagerController::class,'manager']);
            Route::post('manager/delete',[ManagerController::class,'delete']);
            Route::post('manager/update',[ManagerController::class,'update']);
            Route::post('manager/create',[ManagerController::class,'create']);
            Route::post('manager/checkemailexists',[ManagerController::class,'checkEmailExists']);
        });
        Route::group(['middleware'=> 'adminisrole12'], function(){
            Route::get('/categories',[CategoryController::class,'categories']);
            Route::post('/categories/create',[CategoryController::class,'create']);
            Route::post('/categories/delete',[CategoryController::class,'delete']);
            Route::post('/categories/update',[CategoryController::class,'update']);

            Route::get('/products',[ProductController::class,'products']);
            Route::post('/products/create',[ProductController::class,'create']);
            Route::post('/products/delete',[ProductController::class,'delete']);
            Route::post('/products/update',[ProductController::class,'update']);

            Route::get('/types',[TypeController::class,'types']);
            Route::get('/types/create',[TypeController::class,'showCreateForm']);
            Route::post('/types/create',[TypeController::class,'create']);
            Route::get('/types/update/{id}',[TypeController::class,'showUpdateForm']);
            Route::post('/types/update',[TypeController::class,'update']);
            Route::post('/types/upload',[TypeController::class,'upload']);
            Route::post('/types/delete',[TypeController::class,'delete']);
            Route::post('/types/getImages',[TypeController::class,'getImages']);
            Route::post('/types/getProductId',[TypeController::class,'getProductId']);

            Route::get('/promotions',[PromotionController::class,'index']);
            Route::post('/promotions/deletetype',[PromotionController::class,'deleteType']);
            Route::post('/promotions/delete',[PromotionController::class,'delete']);
            Route::post('/promotions/create',[PromotionController::class,'create']);
            Route::post('/promotions/update',[PromotionController::class,'update']);
            
            Route::get('filemanager',[HomeSortController::class,'fileManager']);
            Route::get('homesorts',[HomeSortController::class,'homeSort']);
            Route::get('homesorts/up/{id}',[HomeSortController::class,'up']);
            Route::get('homesorts/down/{id}',[HomeSortController::class,'down']);
            Route::get('homesorts/delete/{id}',[HomeSortController::class,'delete']);
            Route::get('homesorts/update/{id}',[HomeSortController::class,'showHomeSortUpdate']);
            Route::post('homesorts/update/{id}',[HomeSortController::class,'homeSortUpdate']);
            Route::get('homesorts/create',[HomeSortController::class,'showHomeSortCreate']);
            Route::post('homesorts/create',[HomeSortController::class,'homeSortCreate']);

            Route::group(['prefix' => 'filemanager-plugin'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
           });
        });
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
        Route::get('/logout',[AuthenticateController::class,'logout']);
        Route::get('/profile',[ProfileController::class,'profile']);
        Route::post('/profile/changepassword',[ProfileController::class,'changePassword']);
        Route::post('/profile/update',[ManagerController::class,'update']);
        Route::get('/importcsv',[TypeController::class,'showImportCsvForm']);
        Route::post('/importcsv',[TypeController::class,'importCsv']);

        Route::get('/orders' ,[OrderController::class,'orders']);
        Route::get('/orders/date/{from}/{to}',[OrderController::class,'orders']);
        Route::get('/orders/{id}' ,[OrderController::class,'orderInfo']);
        Route::post('/orders/confirm' ,[OrderController::class,'confirm']);
        Route::post('/orders/unconfirm' ,[OrderController::class,'unConfirm']);
        Route::post('/orders/start_deliver' ,[OrderController::class,'start_deliver']);
        Route::post('/orders/delivered' ,[OrderController::class,'delivered']);
        Route::post('/orders/problem' ,[OrderController::class,'problem']);
        
    });
    Route::get('/login', [AuthenticateController::class,'showLoginForm'])->middleware('adminlogged');
    Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
    Route::post('/forgotpassword',[AuthenticateController::class,'forgotPassword']);
    Route::get('/createpassword/{token}',[AuthenticateController::class, 'showCreatePassword']);
    Route::post('/createpassword/{token}',[AuthenticateController::class, 'createPassword']);
    Route::post('/login', [AuthenticateController::class,'login']);
});
