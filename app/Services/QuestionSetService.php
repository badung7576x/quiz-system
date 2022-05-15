<?php

namespace App\Services;

use App\Models\QuestionSet;

class QuestionSetService
{ 
  public function all()
  {
    return QuestionSet::with('subject')->withCount('questions')->latest()->get();
  }

  public function create(array $data)
  {
    return QuestionSet::create($data);
  }

  public function update(QuestionSet $qSet, array $data)
  {
    return $qSet->update($data);
  }

  public function delete(QuestionSet $qSet)
  {
    $qSet->questions()->delete();
    return $qSet->delete();
  }
}
