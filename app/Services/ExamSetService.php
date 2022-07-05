<?php

namespace App\Services;

use App\Models\ExamSet;
use App\Models\Question;
use App\Models\QuestionBank;
use Exception;
use Illuminate\Support\Facades\DB;

class ExamSetService
{

  public function all()
  {
    $user = auth()->user();
    return ExamSet::where('created_by', $user->id)->latest()->get();
  }

  public function create($data)
  {
    $user = auth()->user();
    DB::beginTransaction();
    try {
      $numOfSet = $data['num_of_set'];
      $examSet = ExamSet::create($data);

      $numOfQuestions = $data['total_question'];
      $totalQuestionCount = QuestionBank::where('subject_id', $user->subject_id)->count();

      if ($totalQuestionCount < $numOfQuestions * GENERATE_RATIO) {
        throw new Exception('Số lượng câu hỏi trong ngân hàng đề không đủ');
      }

      $questionIds = QuestionBank::inRandomOrder()
        ->whereIn('subject_content_id', $data['subject_content_ids'])
        ->orderBy('level', 'desc')
        ->limit($numOfQuestions)->pluck('id')->toArray();

      if (count($questionIds) < $numOfQuestions) {
        throw new Exception('Số lượng câu hỏi trong ngân hàng đề không đủ');
      }

      $questionMap = [];
      foreach ($questionIds as $level => $questionId) {
        $questionMap[] = [
          'question_id' => $questionId
        ];
      }

      $examSet->questions()->attach($questionMap);

      for($i = 1; $i <= $numOfSet; $i++) {
        $examSet->examSetDetails()->create([
          'code' => $data['code'] . str_pad($i, 3, "0", STR_PAD_LEFT),
          'question_order' => '',
          'answers' => ''
        ]);
      }
      
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

  public function delete(ExamSet $examSet)
  {
    return $examSet->delete();
  }
}
