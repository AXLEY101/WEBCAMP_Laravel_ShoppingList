<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User as UserModel;
use App\Models\CompletedTask as CompletedTaskModel;

class UserController extends Controller
{
    /**
     * トップページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list(){
        //データの取得
        $group_by_column = ['users.id','users.name'];
        $list = UserModel::select($group_by_column)
                        ->selectRaw('COUNT(completed_tasks.user_id) AS task_num')
                        //->leftJoin('tasks','user_id','=','tasks.user_id')
                        ->leftJoin('completed_tasks','user_id','=','completed_tasks.user_id')
                        ->groupBy($group_by_column)
                        ->orderBy('users.id')
                        ->get();
        
    // echo "<pre>\n";
    // var_dump($list->toArray());exit;
        
        return view('admin.user.list',['users'=>$list]);
    }
}