<?php

namespace App\Services;

use App\Exports\QuestionExport;
use App\Models\Answer;
use App\Models\AnswerBank;
use App\Models\Question;
use App\Models\QuestionBank;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class QuestionBankService
{

  public function deleteQuestion(QuestionBank $question)
  {
    if (!Gate::allows('is_pro_chief')) {
      abort(403);
    }
    
    return $question->delete();
  }

  public function getQuestionBank(array $filters)
  {
    $user = auth()->user();
    $query = QuestionBank::with(['teacher:id,fullname'])->where('subject_id', $user->subject_id);

    if (array_key_exists('subject_content_ids', $filters) && count($filters['subject_content_ids']) > 0) {
      $query->whereIn('subject_content_id', $filters['subject_content_ids']);
    }

    if (array_key_exists('from', $filters) && $filters['from']) {
      $query->whereDate('created_at', '>=', Carbon::parse($filters['from'])->format('Y-m-d'));
    }

    if (array_key_exists('to', $filters) && $filters['to']) {
      $query->whereDate('created_at', '<=', Carbon::parse($filters['to'])->format('Y-m-d'));
    }

    return $query->latest()->get();
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

  public function export(array $filters)
  {
    $user = auth()->user();
    $query = QuestionBank::with(['teacher:id,fullname'])->where('subject_id', $user->subject_id);

    if (array_key_exists('subject_content_ids', $filters) && count($filters['subject_content_ids']) > 0) {
      $query->whereIn('subject_content_id', $filters['subject_content_ids']);
    }

    if (array_key_exists('from', $filters) && $filters['from']) {
      $query->whereDate('created_at', '>=', Carbon::parse($filters['from'])->format('Y-m-d'));
    }

    if (array_key_exists('to', $filters) && $filters['to']) {
      $query->whereDate('created_at', '<=', Carbon::parse($filters['to'])->format('Y-m-d'));
    }

    $data = $query->latest()->get();

    return Excel::download(new QuestionExport($data), 'Questions.xlsx');
  }

}
