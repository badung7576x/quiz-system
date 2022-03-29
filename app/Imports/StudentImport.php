<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classes;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

HeadingRowFormatter::default('none');

class StudentImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    use Importable, SkipsErrors;

    private $class;

    public function __construct(Classes $class)
    {
        $this->class = $class;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if(!isset($row['Tên']) || empty($row['Tên'])) {
        //     return null;
        // }

        $student = new Student([
            'class_id' => $this->class->id,
            'student_code' => '',
            'last_name' => $row['Họ và tên đệm'] ?? '',
            'first_name' => $row['Tên'] ?? '',
            'gender' => $row['Giới tính'] == GENDER['MALE'] ?  'MALE' : 'FEMALE',
            'date_of_birth' => $row['Ngày sinh'] ?? ''
        ]);

        return $student;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function onError(Throwable $e)
    {
        Log::error($e->getMessage());
    }
}
