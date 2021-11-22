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
use App\Http\Controllers\Admin\SubcriberController;
use App\Http\Controllers\Admin\SupportController;
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
            Route::get('/manager/admins',[ManagerController::class,'managerAdmins']);
            Route::post('manager/admins/create',[ManagerController::class,'create']);
            Route::get('manager/admins/{id}/delete',[ManagerController::class,'delete']);
            Route::post('manager/admins/{id}/update',[ManagerController::class,'update']);
            Route::post('manager/checkemailexists',[ManagerController::class,'checkEmailExists']);
            Route::get('/importcsv',[TypeController::class,'showImportCsvForm']);
            Route::post('/importcsv',[TypeController::class,'importCsv']);
            Route::get('/manager/users',[ManagerController::class,'managerUsers']);
            Route::post('/manager/users/{id}/delete',[ManagerController::class,'deleteUser']);

        });
        Route::group(['middleware'=> 'adminisrole12'], function(){
            Route::get('/categories',[CategoryController::class,'categories']);
            Route::post('/categories/create',[CategoryController::class,'create']);
            Route::post('/categories/{id}/delete',[CategoryController::class,'delete']);
            Route::post('/categories/mutipledelete',[CategoryController::class,'mutipleDelete']);
            Route::post('/categories/{id}/update',[CategoryController::class,'update']);

            Route::get('/products',[ProductController::class,'products']);
            Route::post('/products/create',[ProductController::class,'create']);
            Route::post('/products/{id}/delete',[ProductController::class,'delete']);
            Route::post('/products/mutipledelete',[ProductController::class,'mutipleDelete']);
            Route::post('/products/{id}/update',[ProductController::class,'update']);

            Route::get('/types',[TypeController::class,'types']);
            Route::get('/types/create',[TypeController::class,'showCreateForm']);
            Route::post('/types/create',[TypeController::class,'create']);
            Route::get('/types/{id}/update',[TypeController::class,'showUpdateForm']);
            Route::post('/types/{id}/update',[TypeController::class,'update']);
            Route::post('/types/{id}/delete',[TypeController::class,'delete']);
            Route::post('/types/mutipledelete',[TypeController::class,'mutipleDelete']);
            Route::post('/types/{id}/getImages',[TypeController::class,'getImages']);
            Route::post('/types/getProductId',[TypeController::class,'getProductId']);
            Route::get('/types/{id}',[TypeController::class,'typeInfo']);
            
            Route::get('/promotions',[PromotionController::class,'index']);
            Route::post('/promotions',[PromotionController::class,'create']);
            Route::get('/promotions/{id}',[PromotionController::class,'info']);
            Route::get('/promotions/{id}/up',[PromotionController::class,'up']);
            Route::get('/promotions/{id}/down',[PromotionController::class,'down']);
            Route::post('/promotions/deletetype',[PromotionController::class,'deleteType']);
            Route::post('/promotions/{id}/delete',[PromotionController::class,'delete']);
            Route::post('/promotions/{id}/update',[PromotionController::class,'update']);
            
            Route::get('filemanager',[HomeSortController::class,'fileManager']);
            Route::get('homesorts',[HomeSortController::class,'homeSort']);
            Route::get('homesorts/{id}/up',[HomeSortController::class,'up']);
            Route::get('homesorts/{id}/down',[HomeSortController::class,'down']);
            Route::post('homesorts/{id}/delete',[HomeSortController::class,'delete']);
            Route::get('homesorts/{id}/update',[HomeSortController::class,'showHomeSortUpdate']);
            Route::post('homesorts/{id}/update',[HomeSortController::class,'homeSortUpdate']);
            Route::get('homesorts/create',[HomeSortController::class,'showHomeSortCreate']);
            Route::post('homesorts/create',[HomeSortController::class,'homeSortCreate']);

            Route::group(['prefix' => 'filemanager-plugin'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
           });

           Route::get('subcribers',[SubcriberController::class,'index']);
           Route::get('subcribers/{id}/delete',[SubcriberController::class,'delete']);
           Route::get('subcribers/newemail',[SubcriberController::class,'newEmail']);
           Route::post('subcribers/action',[SubcriberController::class,'action']);


        });
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
        Route::get('dashboard/test',[DashboardController::class,'getChart']);
        Route::get('/dashboard/getchart',[DashboardController::class,'getChart']);
        Route::get('/logout',[AuthenticateController::class,'logout']);
        Route::get('/profile',[ProfileController::class,'profile']);
        Route::post('/profile/changepassword',[ProfileController::class,'changePassword']);
        Route::post('/profile/update',[ProfileController::class,'update']);
       

        Route::get('supports',[SupportController::class, 'index']);
        Route::get('supports/{id}',[SupportController::class, 'details']);
        Route::post('supports/{id}',[SupportController::class, 'reply']);

        Route::get('/orders' ,[OrderController::class,'orders']);
        Route::get('/orders/date/{from}/{to}',[OrderController::class,'orders']);
        Route::get('/orders/{id}' ,[OrderController::class,'orderInfo']);
        Route::post('/orders/{id}/confirm' ,[OrderController::class,'confirm']);
        Route::post('/orders/{id}/unconfirm' ,[OrderController::class,'unConfirm']);
        Route::post('/orders/{id}/start_deliver' ,[OrderController::class,'start_deliver']);
        Route::post('/orders/{id}/delivered' ,[OrderController::class,'delivered']);
        Route::post('/orders/{id}/problem' ,[OrderController::class,'problem']);
        
    });
    Route::get('/login', [AuthenticateController::class,'showLoginForm'])->middleware('adminlogged');
    Route::get('/forgotpassword',[AuthenticateController::class,'showForgotPasswordForm']);
    Route::post('/forgotpassword',[AuthenticateController::class,'forgotPassword']);
    Route::get('/createpassword/{token}',[AuthenticateController::class, 'showCreatePassword']);
    Route::post('/createpassword/{token}',[AuthenticateController::class, 'createPassword']);
    Route::post('/login', [AuthenticateController::class,'login']);
});
