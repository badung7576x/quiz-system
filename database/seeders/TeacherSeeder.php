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
            'password' => bcrypt('123123'),
            'phone_number' => '0987168266',
            'date_of_birth' => '1986-01-01',
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
            'password' => Hash::make('123123'),
            'phone_number' => '0987168266',
            'date_of_birth' => '1997-01-01',
            'title' => 'Giáo viên Tiếng Anh',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '8323823123124',
            'group' => 1,
            'gender' => 1,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC002',
            'avatar' => '',
            'fullname' => 'Nguyễn Thị Hương',
            'email' => 'teacher02@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0987168267',
            'date_of_birth' => '1997-01-01',
            'title' => 'Giáo viên Tiếng Anh',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '9323823123124',
            'group' => 1,
            'gender' => 0,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC003',
            'avatar' => '',
            'fullname' => 'Đào Hoàng Anh',
            'email' => 'teacher03@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0987168268',
            'date_of_birth' => '1997-05-18',
            'title' => 'Giáo viên Toán',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '7323823123124',
            'group' => 1,
            'gender' => 0,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC004',
            'avatar' => '',
            'fullname' => 'Đặng Văn Tiến',
            'email' => 'teacher04@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0982168568',
            'date_of_birth' => '1994-08-12',
            'title' => 'Giáo viên Toán',
            'address' => 'Hai Bà Trưng, Hà Nội',
            'identity_number' => '8353823123124',
            'group' => 1,
            'gender' => 1,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC005',
            'avatar' => '',
            'fullname' => 'Nguyễn Tiến Thành',
            'email' => 'teacher05@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0982168528',
            'date_of_birth' => '1994-08-12',
            'title' => 'Giáo viên Toán',
            'address' => 'Hai Bà Trưng, Hà Nội',
            'identity_number' => '8353323123124',
            'group' => 1,
            'gender' => 1,
            'role' => 2,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC006',
            'avatar' => '',
            'fullname' => 'Hoàng Hạo Nam',
            'email' => 'teacher06@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0982165568',
            'date_of_birth' => '1994-08-12',
            'title' => 'Giáo viên Toán',
            'address' => 'Hai Bà Trưng, Hà Nội',
            'identity_number' => '8357823123124',
            'group' => 1,
            'gender' => 1,
            'role' => 3,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TC007',
            'avatar' => '',
            'fullname' => 'Nguyễn Thị Lý',
            'email' => 'teacher07@gmail.com',
            'password' => Hash::make('123123'),
            'phone_number' => '0982165562',
            'date_of_birth' => '1994-08-12',
            'title' => 'Giáo viên Toán',
            'address' => 'Hai Bà Trưng, Hà Nội',
            'identity_number' => '8357823126114',
            'group' => 1,
            'gender' => 0,
            'role' => 4,
            'status' => 1
        ]);
    }
}
