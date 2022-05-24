<?php 
namespace App\Services;

use App\Models\Teacher;

class TeacherService
{

  public function all()
  {
    return Teacher::where('role', '!=', ROLE_ADMIN)->latest()->get();
  }

  public function getSpecialTeachers()
  {
    return Teacher::whereIn('role', [ROLE_SPECIALIST_TEACHER, ROLE_PRO_CHIEF])->latest()->get();
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
    if(isset($data['avatar'])){
      $uploadImageService = new UploadImageService();
      $data['avatar'] = $uploadImageService->upload($data['avatar']->get())['url'];
    }
    return $teacher->update($data);
  }

  public function delete(Teacher $teacher)
  {
    return $teacher->delete();
  }
}
