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

        $csvFile = fopen(base_path("database/data/questions.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                if (count($data) <= 0) break;
                $question = QuestionBank::create([
                    'subject_id' => $data[1],
                    'subject_content_id' => $data[2],
                    'level' => rand(1,3),
                    'type' => 1,
                    'content' => $data[5],
                    'created_by' => $data[13],
                    'review_by' => rand(2,3),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                AnswerBank::insert([
                    [
                        'question_id' => $question->id,
                        'order' => 1,
                        'content_1' => $data[7],
                        'is_correct' => $data[11] == 1
                    ],
                    [
                        'question_id' => $question->id,
                        'order' => 1,
                        'content_1' => $data[8],
                        'is_correct' => $data[11] == 2
                    ],
                    [
                        'question_id' => $question->id,
                        'order' => 1,
                        'content_1' => $data[9],
                        'is_correct' => $data[11] == 3
                    ],
                    [
                        'question_id' => $question->id,
                        'order' => 1,
                        'content_1' => $data[10],
                        'is_correct' => $data[11] == 4
                    ],
                ]); 
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
