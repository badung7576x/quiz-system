<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\Student;

class StudentService
{
  public function create(Classes $class, array $data)
  {
    return $class->students()->create($data);
  }

  public function update(Student $student, array $data)
  {
    return $student->update($data);
  }

  public function delete(Student $student)
  {
    return $student->delete();
  }
}
