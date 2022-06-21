<?php

namespace App\Services;

use App\Imports\QuestionImport;
use Maatwebsite\Excel\Facades\Excel;

class FileService
{
    public function importQuestions($file)
    {
        Excel::import(new QuestionImport, $file);
    }
}
