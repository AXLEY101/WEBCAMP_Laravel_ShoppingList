<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPostRequest;  //買い物リスト用の仕様Routeを見て、名前変更必要か確認する事
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * トップページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
       
        return view('user.register');
    }
    
   
    
    /*
    *　買い物リストの登録
    */
    public function register(UserRegisterPostRequest $request){
        //バリデート済み
        $datum = $request->validated();
        // // $user = Auth::user();
        // $id = Auth::id();
        
        // user_id の追加
        // $datum['user_id'] = Auth::id(); //ログインしてないので。
        
        // passwordをハッシュ化
        $datum['password'] = Hash::make($datum['password']);
        
        //var_dump($datum);
        
        // テーブルへのINSERT
        try{
        $r = UserModel::create($datum);

        } catch(\Throwable $e){
            // XXX 本当はログに書く等の処理をする　今回は出力のみ
            echo $e->getMessage();
            exit;
        }
        
        //　買い物登録完了
        $request->session()->flash('front.user_register_success',true);
        
        //
        return redirect('/');
        
    }
    
    /**
     * 買い物リストのdeteilはいらない
     * 
    */
    
    /**
     * 「単一のタスク」Modelの取得
     */
    // protected function getTaskModel($task_id)
    // {
    //     // task_idのレコードを取得する
    //     $task = UserModel::find($task_id);
    //     if ($task === null) {
    //         return null;
    //     }
    //     // 本人以外のタスクならNGとする
    //     if ($task->user_id !== Auth::id()) {
    //         return null;
    //     }
    //     //
    //     return $task;
    // }
    
    

    
}