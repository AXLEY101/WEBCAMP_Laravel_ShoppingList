<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;  //買い物リスト用の仕様Routeを見て、名前変更必要か確認する事
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingList as ShoppingListModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;  //モデル呼び出しなのでテーブル切り替え時名前変更必要

use Carbon\Carbon;

class CompletedShoppingListController extends Controller
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
        $list = $this->getListBuilder()
                            ->paginate($per_page);
                        //  ->get();
                            //ソートはDESCとASCが昇順降順
    //$sql = $this->getListBuilder()->toSql();
    //echo "<pre>\n"; var_dump($sql,$list);exit;
        
        return view('completed_shopping_list.list',['list' => $list]);
    }
    
    /**
     * 一覧用のIlluminate\Database\Eloquent\Builder インスタンスの取得
    */
    protected function getListBuilder(){
        //
        return CompletedShoppingListModel::where('user_id',Auth::id())
                            ->orderBy('name','ASC')
                            ->orderBy('created_at','ASC')
                        //  ->get()
                            ;
                            //ソートはDESCとASCが昇順降順
        
    }
    
    
}