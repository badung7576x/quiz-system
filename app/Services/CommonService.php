<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\Subject;
use App\Models\SubjectContent;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class CommonService
{

  public function getRoles()
  {
    $user = auth()->user();
    $roles = config('fixeddata.role');

    if ($user->role != ROLE_ADMIN) {
      unset ($roles[ROLE_ADMIN]);
      return $roles;
    }

    return $roles;
  }

  public function getSummary()
  {
    $totalQuestionInBank = QuestionBank::active()->count();
    $waitings = Question::active()->whereStatus(QUESTION_STATUS_REVIEWED)->count();
    $teacher = Teacher::active()->where('role', '!=', ROLE_ADMIN)->count();
  
    return [
      'total' => $totalQuestionInBank,
      'waitting' => $waitings,
      'teacher' => $teacher
    ];
  }

  public function getAnalysisTeacher()
  {
    $data = Teacher::active()->where('role', '!=', ROLE_ADMIN)
      ->select('role', DB::raw('count(*) as total'))->groupBy('role')->orderBy('role', 'desc')->get();

    $result = [
      'role' => collect($data)->pluck('role'),
      'data' => collect($data)->pluck('total')
    ];
    
    return $result;
  }

  public function getAnalysisQuestionBank()
  {
    $questions = QuestionBank::with('subject_content:id,name')->active()
      ->select('subject_content_id', DB::raw('count(*) as total'))
      ->groupBy('subject_content_id')->pluck('total', 'subject_content_id')->toArray();
    
    $subject = SubjectContent::active()->pluck('name', 'id');

    $data = collect($subject)->map(function ($value, $key) use ($questions) {
      return array_key_exists($key, $questions) ? $questions[$key] : 0;
    });
    
    $result = [
      'name' => collect($subject)->values(),
      'data' => collect($data)->values()
    ];
    
    return $result;
  }
}
