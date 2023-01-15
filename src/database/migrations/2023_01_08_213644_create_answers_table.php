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
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // idカラムを追加
            $table->string('username'); // usernameカラムを追加
            $table->integer('question_id'); // question_idカラムを追加
            $table->text('answer_content'); // answer_contentカラムを追加
            $table->timestamps(); // created_at, updated_atカラムを追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
