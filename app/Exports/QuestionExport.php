<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;

    public function __construct($questions)
    {
        $this->data = $questions;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $types = config('fixeddata.question_type');
        foreach ($types as $key => $type) {
            $filteredData = collect($this->data)->filter(fn($item) => $item->type == $key);
            $sheets[] = new QuestionByTypeSheet($filteredData, $key, $type);
        }

        return $sheets;
    }
}
