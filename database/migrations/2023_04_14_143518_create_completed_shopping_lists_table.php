<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedShoppingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_shopping_lists', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name',255)->comment('「買うもの」名');
            
            //買い物リストではいらないので
            // $table->date('period')->comment('タスクの期限');
            // $table->text('detail')->comment('タスクの詳細');
            // $table->unsignedTinyInteger('priority')->comment('重要度:(1:低い, 2:普通, 3:高い)');
            
            $table->unsignedBigInteger('user_id')->comment('この記述者ID');
            $table->foreign('user_id')->references('id')->on('users');//外部キー制約
            //$table->timestamps();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            //
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completed_shopping_lists');
    }
}
