<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\DB;

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
    return Question::with('subject:name,id')
      ->whereNull('review_by')
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

  public function getAllCommentForQuestion(Question $question)
  {
    return Comment::whereQuestionId($question->id)->whereNull('comment_id')->with('commentor:id,fullname')->latest()->get();
  }

  public function assign(array $questions, $teacher_id)
  {
    DB::transaction(function () use ($questions, $teacher_id) {
      foreach ($questions as $question) {
        Question::find($question)->update([
          'review_by' => $teacher_id,
          'status' => QUESTION_STATUS_WAITING_REVIEW
        ]);
      }
    });
  }

  public function reviewQuestion(Question $question, $status)
  {
    $question->update([
      'status' => $status
    ]);
  }
}
