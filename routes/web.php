<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// ShoppingListControllerになる
//use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShoppingListController;

// CompletedShoppingListControllerになる
//use App\Http\Controllers\CompletedTaskController;
use App\Http\Controllers\CompletedShoppingListController;


use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


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



// 会員登録
Route::prefix('/user')->group(function (){
    Route::get('/register',[UserController::class, 'index'])->name('front.user.register');
    Route::post('/register',[UserController::class, 'register'])->name('front.user.register.post');
    
});

// prefixがtask からshopping_listへ name()の引数も変更のため注意 whereNumber()も
//認可処理
// Route::middleware(['auth'])->group(function () {
//     Route::prefix('/task')->group(function (){
//         //Route::get('/list', [TaskController::class, 'list'])->name('front.list');
//         Route::post('/register', [TaskController::class, 'register']);
       
//         Route::delete('/delete/{task_id}',[TaskController::class, 'delete'])->whereNumber('task_id')->name('delete');
//         Route::post('/complete/{task_id}',[TaskController::class, 'complete'])->whereNumber('task_id')->name('complete');
        
//     });
//     // 購入済み「買うもの」一覧 completed_tasks/listからcompleted_shopping_list/listへ
//     Route::get('/completed_tasks/list',[CompletedTaskController::class, 'list']);
//     // ログアウト　変更なし？
//     //Route::get('/logout', [AuthController::class, 'logout']);
        
//});

//こっちに切り替え
// 認可処理
Route::middleware(['auth'])->group(function () {
    Route::prefix('/shopping_list')->group(function () {
        Route::get('/list', [ShoppingListController::class, 'list'])->name('front.list');
        Route::post('/register', [ShoppingListController::class, 'register']);
        Route::delete('/delete/{shopping_list_id}', [ShoppingListController::class, 'delete'])->whereNumber('shopping_list_id')->name('delete');
        Route::post('/complete/{shopping_list_id}', [ShoppingListController::class, 'complete'])->whereNumber('shopping_list_id')->name('complete');
    });
    // 購入済み「買うもの」一覧
    Route::get('/completed_shopping_list/list', [CompletedShoppingListController::class, 'list']);
    // ログアウト
    Route::get('/logout', [AuthController::class, 'logout']);
});








//対応するテーブルがtasksからshoppingに変わるので変更あり注意
//管理画面
Route::prefix('/admin')->group(function (){
   Route::get('',[AdminAuthController::class,'index'])->name('admin.index');
   Route::post('/login',[AdminAuthController::class,'login'])->name('admin.login');
   //
   Route::middleware(['auth:admin'])->group(function(){
       Route::get('/top',[AdminHomeController::class, 'top'])->name('admin.top');
       Route::get('/user/list',[AdminUserController::class,'list'])->name('admin.user.list');
       
        });
   Route::get('/logout',[AdminAuthController::class,'logout']);
});


