<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('title'); 
            $table->string('category'); //カテゴリ
            $table->integer('answer_count');//回答数
            $table->boolean('is_solved')->default(false);//回答済み判定
            $table->json('content');//質問内容
            $table->string('user_name'); //ユーザネーム
            $table->integer('view_count');//閲覧数
            $table->timestamps();



          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
