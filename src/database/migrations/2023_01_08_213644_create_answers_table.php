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
            $table->id(); // id�J������ǉ�
            $table->string('username'); // username�J������ǉ�
            $table->integer('question_id'); // question_id�J������ǉ�
            $table->text('answer_content'); // answer_content�J������ǉ�
            $table->timestamps(); // created_at, updated_at�J������ǉ�
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
