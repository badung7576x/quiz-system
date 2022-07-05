<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\AnswerBank;
use App\Models\Question;
use App\Models\QuestionBank;
use Exception;
use Illuminate\Support\Facades\DB;
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

  public function approvedQuestion(Question $question, $status, $ignore)
  {
    if ($status == QUESTION_STATUS_REJECTED) {
      $question->update([
        'status' => $status
      ]);
      return [
        'success' => true,
        'message' => "Đã từ chối thêm câu hỏi vào ngân hàng đề thi."
      ];
    } else {
      $duplicateQuestions = QuestionBank::whereIn('id', [1, 2, 3])->get();

      if (count($duplicateQuestions) > 0 && !$ignore) {
        return [
          'success' => false,
          'message' => "Câu hỏi có thể bị trùng lặp với một số câu hỏi dưới đây. Bạn có muốn tiếp tục thêm câu hỏi vào ngân hàng đề thi.",
          'data' => view('admin.question._duplicate-question', compact('duplicateQuestions', 'question'))->render()
        ];
      }

      $this->addQuestionToBank($question);
      $question->update([
        'status' => $status
      ]);
      return [
        'success' => true,
        'message' => "Đã thêm câu hỏi vào ngân hàng câu hỏi.",
      ];
    }
  }

  public function addQuestionToBank(Question $question)
  {
    $answers = $question->answers;

    $questionData = $question->toArray();
    unset($questionData['id']);
    
    try {
      DB::beginTransaction();
      $question = QuestionBank::create($questionData);
      
      foreach($answers as $answer) {
        $answerData = $answer->toArray();
        unset($answerData['id']);
        $question->answers()->create($answerData);
      }
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

}
