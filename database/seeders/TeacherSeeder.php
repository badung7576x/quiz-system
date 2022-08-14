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
            'password' => '123123',
            'phone_number' => '0981123123',
            'date_of_birth' => '1986-04-01',
            'title' => 'Quản trị viên',
            'address' => 'Hà Nội',
            'identity_number' => '079215000001',
            'subject_id' => 1,
            'gender' => 0,
            'role' => 0,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA099',
            'avatar' => '',
            'fullname' => 'Nguyễn Văn An',
            'email' => 'english.teacher@gmail.com',
            'password' => '123123',
            'phone_number' => '0981123444',
            'date_of_birth' => '1997-01-01',
            'title' => 'Trưởng nhóm chuyên môn Tiếng Anh',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '079215000021',
            'subject_id' => 1,
            'gender' => 1,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA001',
            'avatar' => '',
            'fullname' => 'Hoàng Thanh Tâm',
            'email' => 'english.teacher01@gmail.com',
            'password' => '123123',
            'phone_number' => '0981123717',
            'date_of_birth' => '1995-01-01',
            'title' => 'Giáo viên chuyên môn Tiếng Anh',
            'address' => 'Cầu Giấy, Hà Nội',
            'identity_number' => '079215020001',
            'subject_id' => 1,
            'gender' => 0,
            'role' => 2,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA002',
            'avatar' => '',
            'fullname' => 'Nguyễn Thị Định',
            'email' => 'english.teacher02@gmail.com',
            'password' => '123123',
            'phone_number' => '0981125717',
            'date_of_birth' => '1995-12-21',
            'title' => 'Giáo viên bộ môn Tiếng Anh',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079215026001',
            'subject_id' => 1,
            'gender' => 0,
            'role' => 3,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA003',
            'avatar' => '',
            'fullname' => 'Đặng Văn Đông',
            'email' => 'english.teacher03@gmail.com',
            'password' => '123123',
            'phone_number' => '0981125718',
            'date_of_birth' => '1985-01-21',
            'title' => 'Giáo viên Tiếng Anh',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079215326001',
            'subject_id' => 1,
            'gender' => 1,
            'role' => 4,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA004',
            'avatar' => '',
            'fullname' => 'Nguyễn Hoàng Bách',
            'email' => 'english.teacher04@gmail.com',
            'password' => '123123',
            'phone_number' => '0981125719',
            'date_of_birth' => '1985-01-21',
            'title' => 'Giáo viên chuyên môn Tiếng Anh',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079215566001',
            'subject_id' => 1,
            'gender' => 1,
            'role' => 2,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA005',
            'avatar' => '',
            'fullname' => 'Lê Viết Mạnh',
            'email' => 'english.teacher05@gmail.com',
            'password' => '123123',
            'phone_number' => '0981125719',
            'date_of_birth' => '1985-01-21',
            'title' => 'Giáo viên chuyên môn Tiếng Anh',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079215888801',
            'subject_id' => 1,
            'gender' => 1,
            'role' => 2,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TA006',
            'avatar' => '',
            'fullname' => 'Nguyễn Linh Đan',
            'email' => 'english.teacher06@gmail.com',
            'password' => '123123',
            'phone_number' => '0981125719',
            'date_of_birth' => '1985-01-21',
            'title' => 'Giáo viên',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079555888801',
            'subject_id' => 1,
            'gender' => 0,
            'role' => 4,
            'status' => 1
        ]);


        Teacher::create([
            'code' => 'TH099',
            'avatar' => '',
            'fullname' => 'Lê Minh Hoàng',
            'email' => 'math.teacher@gmail.com',
            'password' => '123123',
            'phone_number' => '0981123544',
            'date_of_birth' => '1997-01-01',
            'title' => 'Trưởng bộ môn Toán 9',
            'address' => 'Đống Đa, Hà Nội',
            'identity_number' => '079215007721',
            'subject_id' => 2,
            'gender' => 1,
            'role' => 1,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TH001',
            'avatar' => '',
            'fullname' => 'Nguyễn Văn Cường',
            'email' => 'math.teacher01@gmail.com',
            'password' => '123123',
            'phone_number' => '0981103717',
            'date_of_birth' => '1985-01-01',
            'title' => 'Giáo viên chuyên môn Toán 9',
            'address' => 'Cầu Giấy, Hà Nội',
            'identity_number' => '079215020801',
            'subject_id' => 2,
            'gender' => 1,
            'role' => 2,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TH002',
            'avatar' => '',
            'fullname' => 'Đinh Quang Mạnh',
            'email' => 'math.teacher02@gmail.com',
            'password' => '123123',
            'phone_number' => '0981195717',
            'date_of_birth' => '1995-12-21',
            'title' => 'Giáo viên bộ môn Toán',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '088215026001',
            'subject_id' => 2,
            'gender' => 1,
            'role' => 3,
            'status' => 1
        ]);

        Teacher::create([
            'code' => 'TH003',
            'avatar' => '',
            'fullname' => 'Dương Văn Nam',
            'email' => 'math.teacher03@gmail.com',
            'password' => '123123',
            'phone_number' => '0981123218',
            'date_of_birth' => '1985-01-21',
            'title' => 'Giáo viên',
            'address' => 'Thanh Xuân, Hà Nội',
            'identity_number' => '079215399001',
            'subject_id' => 2,
            'gender' => 1,
            'role' => 4,
            'status' => 1
        ]);
    }
}
