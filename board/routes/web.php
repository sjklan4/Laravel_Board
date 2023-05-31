<?php

/************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : BoardsController.php
 * 이력         : V001 0530 SJ.Park new
 ***********************************/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

//Board
Route::resource('/boards', BoardsController::class);

// Users
Route::get('/users/login', [UserController::class, 'login'])->name('users.login');
Route::post('/users/loginpost', [UserController::class, 'loginpost'])->name('users.login.post');  //post 방식으로 값을 보내 주는 구문 아래 registration도 같은 구문
Route::get('/users/registration', [UserController::class, 'registration'])->name('users.registration');
Route::post('/users/registrationpost', [UserController::class, 'registrationpost'])->name('users.registration.post');

//logout
Route::get('/users/logout',[UserController::class, 'logout'])->name('users.logout');
Route::get('/users/withdraw',[UserController::class, 'withdraw'])->name('users.withdraw');

// 유저 정보 및 수정
Route::get('/users/userinfo',[UserController::class, 'userinfo'])->name('users.userinfo');
Route::get('/users/useredit',[UserController::class, 'useredit'])->name('users.useredit');
Route::put('/users/usereditpost', [UserController::class, 'usereditpost'])->name('users.usereditpost');