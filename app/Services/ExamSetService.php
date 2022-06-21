<?php

namespace App\Services;

use App\Models\ExamSet;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;

class ExamSetService
{

  public function all()
  {
    $user = auth()->user();
    return ExamSet::where('created_by', $user->id)->latest()->get();
  }

  public function create($data)
  {
    DB::beginTransaction();
    try {
      $examSet = ExamSet::create($data);
      $numOfQuestions = $data['total_question'];

      $questionIds = Question::inRandomOrder()
        ->whereIn('subject_content_id', $data['subject_content_ids'])
        ->limit($numOfQuestions)->pluck('id')->toArray();

      $questionIdsWithOrder = [];
      foreach ($questionIds as $key => $questionId) {
        $questionIdsWithOrder[$questionId] = ['order' => $key + 1];
      }

      $examSet->questions()->attach($questionIdsWithOrder);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  public function formatData(ExamSet $examSet)
  {
    $examSet->load('subject', 'questions', 'questions.answers', 'setting');

    $questions = collect($examSet->questions)->map(function($question) {
      $ques = [
        'content' => $question->content,
      ];

      $maxLength = 0;
      foreach ($question->answers as $answer) {
        $maxLength = max($maxLength, strlen($answer->content_1));
        $ques['answers'][] = [
          'content' => $answer->content_1,
        ];
      }
      $ques['length_answer'] = $maxLength;

      if ($maxLength < 50) {
        $ques['format'] = 'col-3';
      } else if ($maxLength < 100) {
        $ques['format'] = 'col-6';
      } else {
        $ques['format'] = 'col-12';
      }

      return (object) $ques;
    });

    $examSet->questions = $questions;

    return $examSet;
  }

  public function saveSetting(ExamSet $examSet, array $data)
  {
    $examSet->setting()->updateOrCreate(['exam_set_id' => $examSet->id], $data);
  }
}
