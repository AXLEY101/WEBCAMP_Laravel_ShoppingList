<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;  //買い物リスト用の仕様Routeを見て、名前変更必要か確認する事
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要

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
     * 買い物リストのdeteilはいらない
     * 
    */
    
    /**
     * 「単一のタスク」Modelの取得
     */
    protected function getTaskModel($task_id)
    {
        // task_idのレコードを取得する
        $task = TaskModel::find($task_id);
        if ($task === null) {
            return null;
        }
        // 本人以外のタスクならNGとする
        if ($task->user_id !== Auth::id()) {
            return null;
        }
        //
        return $task;
    }
    
    
    /**
     * 削除処理
    */
    public function delete(Request $request, $task_id){
        // task_idのレコードを取得する htmlのactionでtask_idで送られてきてるので変更しないよう注意
        $task = $this->getTaskModel($task_id);
        // 買い物リストを削除する
        if($task !== null){
            $task->delete();
            //削除された事の表示
            $request->session()->flash('front.task_delete_success',true);
        }
        // 一覧に遷移する
        return redirect('task/list');
    }
    
    /**
     * 完了処理
     * 
    */
    public function complete(Request $request, $task_id){
        /* 買い物リストを完了テーブルに移動する*/
        try{
            // トランザクション開始
            DB::beginTransaction();
            
            // task_idのレコードを取得 htmlのactionでtask_idで送られてきてるので変更しないよう注意
            $task = $this->getTaskModel($task_id);
            if ($task === null){
                // task_idが不正なのでトランザクション終了
                throw new \Exception('');
            }
    //var_dump($task->toArray());exit;
            
            // tasks側を削除する
            $task->delete();
            // completed_tasks側にinsertする
            $dask_datum = $task->toArray();
            // 完了テーブルのcreated_atとupdated_atとの衝突を防ぐため消す
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            $r = CompletedTaskModel::create($dask_datum);
            if ($r === null){
                // insertで失敗してるのでトランザクション終了
                throw new \Exception('');
            }
    //echo '処理成功';exit;
            
            // トランザクション終了
            DB::commit();
            //正常完了メッセージ
            $request->session()->flash('front.task_completed_success',true);
        } catch(\Throwable $e){
    //var_dump($e->getMessage());exit;
            // トランザクションの異常終了
            DB::rollBack();
            //完了失敗メッセージ
            $request->session()->flash('front.task_completed_failure',true);
        }
        // 一覧に遷移する
        return redirect('/task/list');
    }
    
}