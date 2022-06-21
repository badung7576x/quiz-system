<?php

namespace Database\Seeders;

use App\Models\AnswerBank;
use App\Models\QuestionBank;
use Illuminate\Database\Seeder;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionBank::truncate();
        AnswerBank::truncate();
        // Question 1
        QuestionBank::create([
            'subject_id' => 1,
            'subject_content_id' => 1,
            'level' => 1,
            'type' => 1,
            'content' => 'In the past, local______were chosen to make sophisticated embroidered costumes for the Vietnamese King, Queen and other Royal family members',
            'created_by' => 2,
            'review_by' => 3,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        AnswerBank::insert([
            [
                'question_id' => 1,
                'order' => 1,
                'content_1' => 'skill workers',
                'is_correct' => true
            ],
            [
                'question_id' => 1,
                'order' => 2,
                'content_1' => 'skillfully works',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'order' => 3,
                'content_1' => 'skillful',
                'is_correct' => false
            ],
            [
                'question_id' => 1,
                'order' => 4,
                'content_1' => 'skilled artisans',
                'is_correct' => false
            ]
        ]);
        // Question 2
        QuestionBank::create([
            'subject_id' => 1,
            'subject_content_id' => 1,
            'level' => 1,
            'type' => 1,
            'content' => 'Villages are becoming popular________in Viet Nam',
            'created_by' => 2,
            'review_by' => 3,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        AnswerBank::insert([
            [
                'question_id' => 2,
                'order' => 1,
                'content_1' => 'tourism attractions',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'order' => 2,
                'content_1' => 'tourist attractions',
                'is_correct' => true
            ],
            [
                'question_id' => 2,
                'order' => 3,
                'content_1' => 'tour attractiveness',
                'is_correct' => false
            ],
            [
                'question_id' => 2,
                'order' => 4,
                'content_1' => 'physical attraction',
                'is_correct' => false
            ]
        ]);
        // Question 3
        QuestionBank::create([
            'subject_id' => 1,
            'subject_content_id' => 2,
            'level' => 1,
            'type' => 1,
            'content' => 'One of my favourite cities is Verona in northern Italy. It is a very ______ city',
            'created_by' => 2,
            'review_by' => 3,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        AnswerBank::insert([
            [
                'question_id' => 3,
                'order' => 1,
                'content_1' => 'spectacular',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'order' => 2,
                'content_1' => 'visual',
                'is_correct' => true
            ],
            [
                'question_id' => 3,
                'order' => 3,
                'content_1' => 'manual',
                'is_correct' => false
            ],
            [
                'question_id' => 3,
                'order' => 4,
                'content_1' => 'skylar',
                'is_correct' => false
            ]
        ]);

        // Question 4
        QuestionBank::create([
            'subject_id' => 1,
            'subject_content_id' => 2,
            'level' => 1,
            'type' => 1,
            'content' => 'Singapore is the first on the list of most ______ cities in Southeast Asia.',
            'created_by' => 2,
            'review_by' => 3,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        AnswerBank::insert([
            [
                'question_id' => 4,
                'order' => 1,
                'content_1' => 'lively',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'order' => 2,
                'content_1' => 'liveable',
                'is_correct' => true
            ],
            [
                'question_id' => 4,
                'order' => 3,
                'content_1' => 'livelihood',
                'is_correct' => false
            ],
            [
                'question_id' => 4,
                'order' => 4,
                'content_1' => 'live',
                'is_correct' => false
            ]
        ]);
    }
}
