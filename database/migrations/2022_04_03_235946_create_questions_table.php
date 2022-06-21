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
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('subject_content_id')->nullable();
            $table->tinyInteger('level')->default(LEVEL_1)->comment('Mức độ câu hỏi');
            $table->tinyInteger('type')->nullable()->comment('Loại câu hỏi');
            $table->text('content')->comnent('Nội dung câu hỏi');
            $table->string('image')->nullable();
            $table->integer('score')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('review_by')->nullable();
            $table->tinyInteger('status')->default(QUESTION_STATUS_CREATED)->comment('Trạng thái câu hỏi');
            $table->softDeletes();
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
