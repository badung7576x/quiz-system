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
                'description' => 'Môn học tiếng Anh cho học sinh lớp 9',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Toán 9',
                'description' => 'Môn học Toán',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        SubjectContent::insert([
            [
                'subject_id' => 1,
                'order' => 1,
                'name' => 'Unit 1: Local Environment',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 2,
                'name' => 'Unit 2: City Life',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 3,
                'name' => 'Unit 3: Teen stress And pressure',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 4,
                'name' => 'Unit 4: Life In The Past',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 5,
                'name' => 'Unit 5: Wonders Of Vietnam',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 6,
                'name' => 'Unit 6: Vietnam Then And Now',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 7,
                'name' => 'Review: Unit 1-6',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 8,
                'name' => 'Unit 7: Recipes And Eating Habbits',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 9,
                'name' => 'Unit 8: Tourism',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 10,
                'name' => 'Unit 9: English In The World',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 11,
                'name' => 'Unit 10 : Space Travel',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 12,
                'name' => 'Unit 11: Changing Roles In Society',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 13,
                'name' => 'Unit 12: My Future Career - Sự nghiệp tương lai của tôi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 1,
                'order' => 14,
                'name' => 'Review 2: Unit 7-12',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Toán
            [
                'subject_id' => 2,
                'order' => 1,
                'name' => 'Chương 1: Căn bậc hai - căn bậc ba',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 2,
                'name' => 'Chương 2: Hàm số bậc nhất',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 3,
                'name' => 'Chương 3: Hệ hai phương trình bậc nhất hai ẩn',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 4,
                'name' => 'Chương 4: Phương trình bậc hai một ẩn',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 5,
                'name' => 'Chương 1: Hệ thức lượng trong tam giác vuông',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 6,
                'name' => 'Chương 2: Đường tròn',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 7,
                'name' => 'Chương 3: Góc với đường tròn',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'subject_id' => 2,
                'order' => 8,
                'name' => 'Chương 4: Hình trụ - Hình nón - Hình cầu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);


    }
}
