<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionExport implements FromView, ShouldAutoSize
{
    protected $data;

    public function __construct($questions)
    {
        $this->data = $questions;
    }

    public function view(): View
    {
        return view('admin.export.question_banks', [
            'data' => $this->data
        ]);
    }
}
