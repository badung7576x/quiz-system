<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

HeadingRowFormatter::default('none');

class QuestionImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $question = Question::create([
                'subject_id' => auth()->user()->subject_id,
                'level' => LEVEL_1,
                'type' => QUESTION_MULTI_CHOICE,
                'content' => $row['Câu hỏi'],
                'score' => $row['Điểm'] ?? 1,
            ]);

            for ($i = 1; $i <= 4; $i++) {
                $question->answers()->create([
                    'content_1' => $row['Đáp án ' . $i],
                    'is_correct' => $row['Đáp án đúng'] == $i,
                    'order' => $i,
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
