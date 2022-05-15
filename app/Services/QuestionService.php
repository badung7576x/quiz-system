<?php

namespace App\Services;

use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\DB;

class QuestionService
{ 
  public function all()
  {
    return Question::with('answers')->latest()->get();
  }

  public function createQuestion(array $data)
  {
    try {
      DB::beginTransaction();
      $question = Question::create($data);
      $answerData = $data['answers'];
      
    } catch (Exception $e) {
      DB::rollBack();
    }
    
    
  }
}
