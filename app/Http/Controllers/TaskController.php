<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * トップページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // 1page当たりの表示アイテム数を設定
        $per_page = 20;
        
        //一覧の取得
        $list = TaskModel::where('user_id',Auth::id())
                            ->orderBy('name','ASC')
                        //  ->orderBy('create_at','DESC')//購入済みリスト用
                            ->paginate($per_page);
                        //  ->get();
                            //ソートはDESCとASCが昇順降順
    //$sql = TaskModel::where('user_id',Auth::id())->toSql();
    //echo "<pre>\n"; var_dump($sql,$list);exit;
        
        return view('task.list',['list' => $list]);
    }
    
    /*
    *　買い物リストの登録
    */
    public function register(TaskRegisterPostRequest $request){
        //バリデート済み
        $datum = $request->validated();
        // // $user = Auth::user();
        // $id = Auth::id();
        
        // user_id の追加
        $datum['user_id'] = Auth::id();
        
        //var_dump($datum);
        
        // テーブルへのINSERT
        try{
        $r = TaskModel::create($datum);

        } catch(\Throwable $e){
            // XXX 本当はログに書く等の処理をする　今回は出力のみ
            echo $e->getMessage();
            exit;
        }
        
        //　買い物登録完了
        $request->session()->flash('front.task_register_success',true);
        
        //
        return redirect('/task/list');
        
    }
    
    /**
     * 買い物リストのdeteilは
     * 
    */

}