<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\welcomeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
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
//買い物リストと購入一覧
Route::get('/',[AuthController::class,'index'])->name('front.index');
Route::post('/login',[AuthController::class, 'login']);
//認可処理
Route::middleware(['auth'])->group(function () {
    Route::get('/task/list', [TaskController::class, 'list']);
    Route::post('/task/register', [TaskController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout']);
});



//formテスト用
//Route::get('/test',[TestController::class,'index']);
//Route::post('/test/input',[TestController::class, 'input']);


//テスト用
//Route::get('/welcome',[welcomeController::class, 'index']);
//Route::get('/welcome/second',[welcomeController::class,'second']);