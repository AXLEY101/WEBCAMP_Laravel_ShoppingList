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
    Route::prefix('/task')->group(function (){
        Route::get('/list', [TaskController::class, 'list']);
        Route::post('/register', [TaskController::class, 'register']);
        //Route::get('/detail/{task_id}',[TaskController::class, 'detail'])->whereNumber('task_id')->name('detail');
        Route::delete('/delete/{task_id}',[TaskController::class, 'delete'])->whereNumber('task_id')->name('delete');
        Route::post('/complete/{task_id}',[TaskController::class, 'complete'])->whereNumber('task_id')->name('complete');
    });
    Route::get('/logout', [AuthController::class, 'logout']);
        
});


//formテスト用
//Route::get('/test',[TestController::class,'index']);
//Route::post('/test/input',[TestController::class, 'input']);


//テスト用
//Route::get('/welcome',[welcomeController::class, 'index']);
//Route::get('/welcome/second',[welcomeController::class,'second']);