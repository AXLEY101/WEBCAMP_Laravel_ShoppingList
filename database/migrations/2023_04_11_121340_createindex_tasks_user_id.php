<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateindexTasksUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 変更したいテーブルを指定し、user_idにインデックスを付与する
        Schema::table('tasks',function(Blueprint $table){
           $table->index('user_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //このマイグレーションファイルを巻き戻した時に元の状態にする操作
        //基本的に上に書いたup()の打ち消しをすればOK
        Schema::table('tasks', function (Blueprint $table){
            //user_idに付与していたインデックスを削除
           $table->dropIndex('user_id');
        });
    }
}
