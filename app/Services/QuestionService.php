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
    return Question::with(['subject:name,id', 'teacher:id,fullname'])
      ->active()// ->whereNull('review_by')
      ->whereStatus(QUESTION_STATUS_CREATED)
      ->latest()->get();
  }

  public function allReviewQuestions()
  {
    return Question::with('subject:name,id')
      ->where('status', '<=', QUESTION_STATUS_REJECTED)
      ->where('review_by', auth()->user()->id)
      ->orderBy('status', 'asc')
      ->latest()->get();
  }

  public function createQuestion(array $data)
  {
    if(isset($data['image'])){
      $uploadImageService = new UploadImageService();
      $data['image'] = $uploadImageService->upload($data['image']->get())['url'];
    }

    $question = Question::create($data);
    foreach ($data['answers'] as $key => $answer) {
      if($question->type == QUESTION_MULTI_CHOICE) {
        $answer = [
          'order' => $key + 1,
          'content_1' => $answer,
          'is_correct' => $data['correct_answer'] == $key + 1,
        ];
      }
      if($question->type == QUESTION_TRUE_FALSE) {
        $answer = [
          'order' => $key + 1,
          'content_1' => $answer,
          'is_correct' => $data['correct_answer'][$key]
        ];
      } 
      if($question->type == QUESTION_SHORT_ANSWER) {
        $answer = [
          'order' => $key + 1,
          'content_1' => $answer,
          'is_correct' => true
        ];
      } 
      $question->answers()->create($answer);
    }
  }

  public function updateQuestion(Question $question, array $data)
  {
    if (!Gate::allows('can-update-question', $question)) {
      abort(403);
    }

    if(isset($data['image'])){
      $uploadImageService = new UploadImageService();
      $data['image'] = $uploadImageService->upload($data['image']->get())['url'];
    }
    
    $question->update($data);
    
    if ($question->type == QUESTION_MULTI_CHOICE) {
      foreach ($data['answers'] as $id => $answer) {
        $oldAnswer = Answer::find($id);
        $order = $oldAnswer->order;
        $oldAnswer->update([
          'content_1' => $answer,
          'is_correct' => $data['correct_answer'] == $order,
        ]);
      }
    } else if ($question->type == QUESTION_SHORT_ANSWER) {
      foreach ($data['answers'] as $id => $answer) {
        $oldAnswer = Answer::find($id);
        $oldAnswer->update([
          'content_1' => $answer,
          'is_correct' => true
        ]);
      }
    } else if ($question->type == QUESTION_TRUE_FALSE) {
      $updateAnswerContent = array_key_exists('answers', $data) ? $data['answers'] : [];
      $updateCorrectAnswer = array_key_exists('correct_answer', $data) ? $data['correct_answer'] : [];
      $newAnswerContent = array_key_exists('new_answers', $data) ? $data['new_answers'] : [];
      $newCorrectAnswer = array_key_exists('new_correct_answer', $data) ? $data['new_correct_answer'] : [];

      $oldAnswerIds = $question->answers->pluck('id')->toArray();
      $count = count($updateAnswerContent);

      // update old answer content
      $newAnswerIds = [];
      foreach ($updateAnswerContent as $key => $each) {
        $newAnswerIds[] = $key;
        $oldAnswer = Answer::find($key);
        $oldAnswer->update([
          'content_1' => $each,
          'is_correct' => $updateCorrectAnswer[$key]
        ]);
      }
      // delete old answer content not in new answer content
      $oldAnswerNeedDeleteIds = array_diff($oldAnswerIds, $newAnswerIds);
      foreach ($oldAnswerNeedDeleteIds as $each) {
        Answer::where('id', $each)->delete();
      }

      // add new answer content
      $tmp = [];
      $contentData = array_unique($newAnswerContent);
      foreach ($contentData as $index => $each) {
        $tmp[] = [
          'order' => $count + $index + 1,
          'content_1' => $each,
          'is_correct' => $newCorrectAnswer[$index+$count+9999]
        ];
      }
      
      $question->answers()->createMany($tmp);
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
