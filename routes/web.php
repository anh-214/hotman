<?php

use App\Http\Controllers\Web\AuthenticateController;
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

Route::get('/login',[AuthenticateController::class, 'showLoginForm']);
Route::post('/login',[AuthenticateController::class, 'login']);
Route::get('/logout',[AuthenticateController::class,'logout']);
Route::get('/register', function(){
    return view('frontend.account.register');
});

Route::get('contact', function () {
    return view('frontend.contact');
});