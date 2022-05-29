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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Mã giáo viên');
            $table->string('avatar')->nullable()->comment('Avatar');
            $table->string('fullname')->nullable()->comment('Họ và tên');
            $table->string('email')->unique()->comment('Email');
            $table->string('phone_number')->nullable()->comment('Số điện thoại');
            $table->date('date_of_birth')->nullable()->comment('Ngày sinh');
            $table->string('title')->nullable()->comment('Chức danh');
            $table->string('address')->nullable()->comment('Địa chỉ');
            $table->string('identity_number')->unique()->comment('CMND/CCCD');
            $table->integer('subject_id')->nullable()->comment('Giảng dạy bộ môn');
            $table->tinyInteger('gender')->comment('0: Nữ, 1: Nam');
            $table->tinyInteger('role')->comment('Admin/Giáo viên');
            $table->string('password')->comment('Mật khẩu');
            $table->string('token')->nullable()->comment('Sử dụng cho việc đăng nhập');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái');
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
        Schema::dropIfExists('teachers');
    }
};
