<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\QuestionBank;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class QuestionService
{

  public function allMyQuestions()
  {
    return Question::with('subject:name,id')
      ->where('created_by', auth()->user()->id)
      ->latest()->get();
  }

  public function all()
  {
    return Question::with('subject:name,id')->latest()->get();
  }

  public function getNonAssignQuestions()
  {
    $user = auth()->user();

    return Question::with(['subject:name,id', 'teacher:id,fullname'])
      ->where('subject_id', $user->subject_id)
      ->whereNull('review_by')
      ->whereStatus(QUESTION_STATUS_CREATED)
      ->latest()->get();
  }

  public function allReviewQuestions()
  {
    return Question::with('subject:name,id')
      ->where('review_by', auth()->user()->id)
      ->orderBy('status', 'asc')
      ->latest()->get();
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
    if (!Gate::allows('can-update-question', $question)) {
      abort(403);
    }

    $question->update($data);
    
    foreach ($data['answers'] as $id => $answer) {
      $oldAnswer = Answer::find($id);
      $order = $oldAnswer->order;
      $oldAnswer->update([
        'content_1' => $answer,
        'is_correct' => $data['correct_answer'] == $order,
      ]);
    }
  }

  public function deleteQuestion(Question $question)
  {
    if (!Gate::allows('can-update-question', $question)) {
      abort(403);
    }
    
    return $question->delete();
  }

  public function getAllCommentForQuestion(Question $question)
  {
    return Comment::whereQuestionId($question->id)->whereNull('comment_id')
      ->with('commentor:id,fullname,avatar')->orderBy('created_at', 'asc')->get();
  }

  public function assign(string $questions, $teacher_id)
  {
    $questions = explode(',', $questions);
    try {
      DB::beginTransaction();
      Question::whereIn('id', $questions)->update([
        'review_by' => $teacher_id,
        'status' => QUESTION_STATUS_WAITING_REVIEW
      ]);
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function reviewQuestion(Question $question, $status)
  {
    $question->update([
      'status' => $status
    ]);
  }

  public function findQuestion($id)
  {
    return Question::with(['teacher:id,fullname', 'reviewer:id,fullname', 'subject_content', 'answers'])->find($id);
  }
}
