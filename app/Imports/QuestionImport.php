<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

HeadingRowFormatter::default('none');

class QuestionImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        $beforeQuestion = null;
        $order = 0;
        foreach ($rows as $row) {
            Log::info($row);
            if ($row['Loại câu hỏi'] == 'MULTI_CHOICE') {
                $level = in_array($row['Độ khó'], [LEVEL_1, LEVEL_2, LEVEL_3]) ? $row['Độ khó'] : LEVEL_1;
                $question = Question::create([
                    'subject_id' => auth()->user()->subject_id,
                    'level' => $level,
                    'type' => QUESTION_MULTI_CHOICE,
                    'content' => $row['Câu hỏi'],
                    'score' => $row['Điểm'] ?? 1,
                ]);
    
                for ($i = 1; $i <= 4; $i++) {
                    $question->answers()->create([
                        'order' => $i,
                        'content_1' => $row['Đáp án ' . $i],
                        'is_correct' => $row['Đáp án đúng'] == $i,
                    ]);
                }
            }
            if ($row['Loại câu hỏi'] == 'TRUE_FALSE' || $row['Loại câu hỏi'] == null) {
                if ($row['Nội dung chính'] != null) {
                    $order = 1;
                    $level = in_array($row['Độ khó'], [LEVEL_1, LEVEL_2, LEVEL_3]) ? $row['Độ khó'] : LEVEL_1;
                    $beforeQuestion = Question::create([
                        'subject_id' => auth()->user()->subject_id,
                        'level' => $level,
                        'type' => QUESTION_TRUE_FALSE,
                        'content' => $row['Nội dung chính'],
                        'score' => $row['Điểm'] ?? 1,
                    ]);
                    $beforeQuestion->answers()->create([
                        'order' => $order,
                        'content_1' => $row['Câu hỏi'],
                        'is_correct' => $row['Đáp án'],
                    ]);
                } else {
                    $order += 1;
                    $beforeQuestion && $beforeQuestion->answers()->create([
                        'order' => $order,
                        'content_1' => $row['Câu hỏi'],
                        'is_correct' => $row['Đáp án'],
                    ]);
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
