<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::truncate();
        Teacher::create([
            'code' => 'AD001',
            'avatar' => '',
            'fullname' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone_number' => '0987168266',
            'date_of_birth' => '1996-01-01',
            'title' => 'Quản trị viên',
            'address' => 'Hà Nội',
            'identity_number' => '8323823123123',
            'group' => 1,
            'gender' => 0,
            'role' => 0,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC001',
            'avatar' => '',
            'fullname' => 'Nguyễn Văn An',
            'email' => 'teacher01@gmail.com',
            'password' => Hash::make('123456'),
            'phone_number' => '0987168266',
            'date_of_birth' => '1997-01-01',
            'title' => 'Giáo viên',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '8323823123124',
            'group' => 1,
            'gender' => 1,
            'role' => 1,
            'status' => 1
        ]);
    }
}
