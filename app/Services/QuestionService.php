<?php

namespace App\Services;

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

  public function acceptQuestionToBank(Question $question)
  {
    // Check question is not already in bank
    // $alreadyQuestions = QuestionBank::searchByQuery(['match' => ['content' => $question->content]]);
    $alreadyQuestions = QuestionBank::whereIn('id', [1, 2, 3])->get();
    
    if (count($alreadyQuestions) > 0) {
      throw new Exception('Question is already in bank');
    }
    
    $question->load('answers');
    $questionBank = QuestionBank::create($question->toArray());
    $questionBank->answers()->create($question->answers->toArray());
  }
}
