<?php 
namespace App\Services;

use App\Models\Subject;

class SubjectService
{

  public function all()
  {
    $user = auth()->user();
    if($user->role == ROLE_ADMIN) {
      return Subject::latest()->get();
    } else {
      return Subject::where('id', $user->subject_id)->latest()->get();
    }
  }

  public function subjectWithContents()
  {
    return Subject::with('contents')->latest()->get();
  }

  public function create(array $data)
  {
    return Subject::create($data);
  }

  public function update(Subject $subject, array $data)
  {
    return $subject->update($data);
  }

  public function delete(Subject $subject)
  {
    return $subject->delete();
  }
}
