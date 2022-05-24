<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Question;

class CommentService
{

  public function create(Question $question, array $data)
  {
    $commentData = [
      'content' => $data['new_comment']
    ];
    return $question->comments()->create($commentData);
  }

  public function update(Comment $comment, array $data)
  {
    $commentData = [
      'content' => $data['comment']
    ];
    $comment->update($commentData);
  }

  public function resolved(Question $question, Comment $comment)
  {
    if ($question->id != $comment->question_id) {
      return false;
    } else {
      $comment->is_resolved = true;
      $comment->save();
      return true;
    }
  }

  public function delete(Comment $comment)
  {
    $comment->reply_comments()->delete();
    $comment->delete();
  }
}
