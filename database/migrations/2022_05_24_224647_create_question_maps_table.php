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
        Schema::create('question_maps', function (Blueprint $table) {
            $table->bigInteger('exam_set_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();

            $table->index(['exam_set_id', 'question_id'], 'question_map_exam_set_id_question_id_idx');
            $table->index('exam_set_id', 'question_map_exam_set_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_maps');
    }
};
