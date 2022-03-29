<?php 
namespace App\Services;

use App\Models\Classes;

class ClassService
{

  public function all()
  {
    return Classes::latest()->paginate(20);
  }

  public function create(array $data)
  {
    return Classes::create($data);
  }

  public function update(Classes $class, array $data)
  {
    return $class->update($data);
  }

  public function delete(Classes $class)
  {
    $class->students()->delete();
    return $class->delete();
  }
}
