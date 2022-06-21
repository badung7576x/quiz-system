<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Support\Facades\Gate;

class QuestionBankService
{

  public function deleteQuestion(QuestionBank $question)
  {
    if (!Gate::allows('is_pro_chief')) {
      abort(403);
    }
    
    return $question->delete();
  }

  public function getQuestionBank()
  {
    $user = auth()->user();
    return QuestionBank::with(['teacher:id,fullname'])
      ->where('subject_id', $user->subject_id)
      ->latest()->get();
  }

  public function allWaitingAcceptQuestions()
  {
    $user = auth()->user();
    return Question::with(['subject:name,id', 'teacher:id,fullname'])
      ->where('subject_id', $user->subject_id)
      ->whereStatus(QUESTION_STATUS_REVIEWED)
      ->latest()->get();
  }

  public function findQuestion($id)
  {
    return QuestionBank::with(['teacher:id,fullname', 'reviewer:id,fullname', 'subject_content', 'answers'])->find($id);
  }

}
