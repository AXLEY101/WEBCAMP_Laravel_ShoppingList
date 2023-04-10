<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TestPostRequest;

class TestController extends Controller
{
    /**
     * トップページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('test.index');
    }
    
    public function input(TestPostRequest $request){
        //validate済み
        
        // データの取得
        $validatedData = $request->validated();
        
        return view('test.input',['datum' => $validatedData]);
    }
   
    
}