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
        Schema::create('exam_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên bộ đề');
            $table->tinyInteger('type')->comment('Loại đề thi');
            $table->integer('subject_id')->comment('Môn học');
            $table->string('subject_content_ids')->comment('Nội dung môn học');
            $table->string('question_types')->comment('Loại câu hỏi');
            $table->integer('execute_time')->comment('Thời gian làm bài');
            $table->integer('total_question')->comment('Tổng số câu hỏi');
            $table->integer('status')->comment('Trạng thái');
            $table->integer('created_by')->comment('Người tạo');
            $table->integer('approved_by')->nullable()->comment('Người tạo');
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
        Schema::dropIfExists('exam_sets');
    }
};
