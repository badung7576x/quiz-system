<?php 
namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;

class TeacherService
{

  public function all()
  {
    return Teacher::where('role', '!=', ROLE_ADMIN)->with('subject:id,name')->latest()->get();
  }

  public function allTeacherBySubject()
  {
    $user = auth()->user();

    if ($user->role == ROLE_ADMIN) {
      return $this->all();
    }
    
    return Teacher::where('subject_id', $user->subject_id)
      ->where('id', '!=', $user->id)
      ->where('role', '!=', ROLE_ADMIN)
      ->with('subject:id,name')->latest()->get();
  }

  public function getSpecialTeachers()
  {
    $user = auth()->user();
    return Teacher::where('subject_id', $user->subject_id)
      ->whereIn('role', [ROLE_SPECIALIST_TEACHER, ROLE_PRO_CHIEF])->latest()->get();
  }

  public function create(array $data)
  {
    if(isset($data['avatar'])){
      $uploadImageService = new UploadImageService();
      $data['avatar'] = $uploadImageService->upload($data['avatar']->get())['url'];
    }
    return Teacher::create($data);
  }

  public function update(Teacher $teacher, array $data)
  {
    if (!Gate::allows('can-access', $teacher)) {
      abort(403);
    }

    if(isset($data['avatar'])){
      $uploadImageService = new UploadImageService();
      $data['avatar'] = $uploadImageService->upload($data['avatar']->get())['url'];
    }
    return $teacher->update($data);
  }

  public function delete(Teacher $teacher)
  {
    if (!Gate::allows('can-access', $teacher)) {
      abort(403);
    }
    
    return $teacher->delete();
  }
}
