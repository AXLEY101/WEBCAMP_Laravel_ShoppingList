<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\welcomeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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
Route::get('/',[AuthController::class,'index']);
Route::get('/task/list',[TaskController::class,'list']);


//テスト用
Route::get('/welcome',[welcomeController::class, 'index']);
Route::get('/welcome/second',[welcomeController::class,'second']);