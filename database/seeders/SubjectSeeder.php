<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubjectContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::truncate();
        SubjectContent::truncate();

        Subject::insert([
            [
                'id' => 1,
                'name' => 'Tiếng Anh',
                'description' => 'Môn học tiếng Anh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Toán',
                'description' => 'Môn học Toán',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        SubjectContent::insert([
            [
                'id' => 1,
                'subject_id' => 1,
                'order' => 1,
                'name' => 'Chương 1: Giới thiệu về tiếng Anh',
                'description' => 'Nội dung chương 1 về tiếng Anh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'subject_id' => 1,
                'order' => 2,
                'name' => 'Chương 2: Các thì cơ bản trong tiếng Anh',
                'description' => 'Nội dung chương 2 về tiếng Anh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'subject_id' => 1,
                'order' => 3,
                'name' => 'Chương 3: Các thì phức tạp trong tiếng Anh',
                'description' => 'Nội dung chương 3 về tiếng Anh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);


    }
}
