<?php

namespace App\Services;

use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\DB;

class QuestionService
{
  public function all()
  {
    return Question::with('subject:name,id')->latest()->get();
  }

  public function createQuestion(array $data)
  {
    $question = Question::create($data);
    foreach ($data['answers'] as $key => $answer) {
      $answer = [
        'order' => $key + 1,
        'content_1' => $answer,
        'is_correct' => $data['correct_answer'] == $key + 1,
      ];
      $question->answers()->create($answer);
    }
  }

  public function updateQuestion(Question $question, array $data)
  {
    $question->update($data);
    $question->answers()->delete();
    foreach ($data['answers'] as $key => $answer) {
      $answer = [
        'order' => $key + 1,
        'content_1' => $answer,
        'is_correct' => $data['correct_answer'] == $key + 1,
      ];
      $question->answers()->create($answer);
    }
  }

  public function deleteQuestion(Question $question)
  {
    $question->answers()->delete();
    $question->delete();
  }
}
