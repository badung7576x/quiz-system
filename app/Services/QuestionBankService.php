<?php

namespace App\Services;

use App\Exports\QuestionExport;
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
    $query = QuestionBank::with(['teacher:id,fullname'])->active();

    if (array_key_exists('question_types', $filters) && count($filters['question_types']) > 0) {
      $query->whereIn('type', $filters['question_types']);
    }

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
    return Question::with(['subject:name,id', 'teacher:id,fullname'])
      ->active()->whereStatus(QUESTION_STATUS_REVIEWED)
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
      $searchKey = preg_replace('<p>', '', $question->content);
      $searchKey = preg_replace('/[^A-Za-z0-9 .]/', ' ', $searchKey);

      $duplicateQuestions = QuestionBank::search('"' . $searchKey)->take(3)->get();

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
      // $question->addToIndex();
      
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
    $query = QuestionBank::with(['teacher:id,fullname'])->active();

    if (array_key_exists('ids', $filters) && $filters['ids']) {
      $query->whereIn('id', explode(",", $filters['ids']));
    } else {
      if (array_key_exists('question_types', $filters) && count($filters['question_types']) > 0) {
        $query->whereIn('type', $filters['question_types']);
      }

      if (array_key_exists('subject_content_ids', $filters) && count($filters['subject_content_ids']) > 0) {
        $query->whereIn('subject_content_id', $filters['subject_content_ids']);
      }
  
      if (array_key_exists('from', $filters) && $filters['from']) {
        $query->whereDate('created_at', '>=', Carbon::parse($filters['from'])->format('Y-m-d'));
      }
  
      if (array_key_exists('to', $filters) && $filters['to']) {
        $query->whereDate('created_at', '<=', Carbon::parse($filters['to'])->format('Y-m-d'));
      }
    }


    $data = $query->latest()->get();

    if (count($data) <= 0) {
      return back()->withInput()->with(['type' => 'error', 'message' => "Không thể tải xuống bộ câu hỏi."]);
    }

    if (array_key_exists('export_type', $filters) && $filters['export_type']) {
      switch ($filters['export_type']) {
        case 'excel':
          return Excel::download(new QuestionExport($data), 'questions.xlsx');
          break;
        case 'csv':
          $data = collect($data)->filter(fn($item) => $item->type == QUESTION_MULTI_CHOICE);
          return $this->_exportCsv($data);
          break;
        case 'aiken':
          $data = collect($data)->filter(fn($item) => $item->type == QUESTION_MULTI_CHOICE);
          return $this->_exportAikenFormat($data);
          break;
        default:
          break;
      }
    }

    return Excel::download(new QuestionExport($data), 'questions.xlsx');
  }

  private function _exportCsv($data)
  {
    $headers = array(
      "Content-type"        => "text/csv",
      "Content-Disposition" => "attachment; filename=question.csv",
      "Pragma"              => "no-cache",
      "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
      "Expires"             => "0"
    );

    $columns = array('stt', 'câu hỏi', 'đáp án 1', 'đáp án 2', 'đáp án 3', 'đáp án 4', 'đáp án đúng', 'điểm');

    $callback = function() use($data, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($data as $idx => $record) {
            $row['no']  = $idx;
            $row['question']    = $record->content;
            foreach ($record->answers as $idx => $answer) {
              if ($answer->is_correct) $correctAns = $idx + 1;
              $row['answer' . $idx + 1]    = $answer->content_1;
            }
            $row['correct_answer']  = $correctAns;
            $row['score']  = $record->score;

            fputcsv($file, array(
              $row['no'], $row['question'], $row['answer1'], $row['answer2'], $row['answer3'], 
              $row['answer4'], $row['correct_answer'], $row['score']));
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  private function _exportAikenFormat($data)
  {
    $headers = array(
      "Content-type"        => "text/plain",
      "Content-Disposition" => "attachment; filename=question.txt",
      "Cache-Control"       => "no-store, no-cache",
    );

    $callback = function() use($data) {
      $file = fopen('php://output', 'w');
      foreach ($data as $idx => $record) {
        $txt = "";
        $txt .= $record->content . "\n";
        foreach ($record->answers as $idx => $answer) {
          if ($answer->is_correct) $correctAns = $idx + 1;
          $txt .= config('fixeddata.answer_index')[$idx + 1] . ". " . $answer->content_1 . "\n";
        }
        $txt .= "ANSWER: " . config('fixeddata.answer_index')[$correctAns] . "\n\n";

        fwrite($file, $txt);
      }

      fclose($file);
  };

    return response()->stream($callback, 200, $headers);
  }
}
