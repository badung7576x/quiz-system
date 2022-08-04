<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionByTypeSheet implements FromView, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $type;
    protected $sheetName;

    public function __construct($questions, $type, $sheetName)
    {
        $this->data = $questions;
        $this->type = $type;
        $this->sheetName = $sheetName;
    }

    public function view(): View
    {
        return view('admin.export.question_banks', [
            'data' => $this->data,
            'type' => $this->type
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sheetName ;
    }
}