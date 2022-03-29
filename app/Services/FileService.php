<?php

namespace App\Services;

use App\Imports\StudentImport;
use App\Models\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileService
{
  public function importStudent(Classes $class, $file)
  {
    DB::beginTransaction();
    try {
      $import = new StudentImport($class);
      $import->import($file);
      if($import->errors()->count() > 0) {
        throw new \Exception("Can't import student with file (" . $file->getClientOriginalName()) . ")";
      }
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      throw new \Exception(__('messages.student.import.error'));
    }
  }
}
