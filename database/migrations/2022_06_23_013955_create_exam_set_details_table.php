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
        Schema::create('exam_set_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_set_id')->comment('Bộ đề chung');
            $table->string('code')->nullable()->comment('Mã đề');
            $table->text('question_order')->nullable()->comment('Thứ tự các câu hỏi');
            $table->string('answers')->nullable()->comment('Đáp án');
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
        Schema::dropIfExists('exam_set_details');
    }
};
