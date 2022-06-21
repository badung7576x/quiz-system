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
        Schema::create('exam_set_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_set_id')->nullable();
            $table->boolean('is_display_top')->default(false);
            $table->text('top_left')->nullable();
            $table->text('top_right')->nullable();
            $table->boolean('is_display_center')->default(true);
            $table->text('center')->nullable();
            $table->boolean('is_display_bottom')->default(false);
            $table->text('bottom')->nullable();
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
        Schema::dropIfExists('exam_set_settings');
    }
};
