<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExcelExtension;

class QuestionSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => 'required|numeric',
            'set_name' => 'required|max:255',
            'import_file' => ['required', 'file', new ExcelExtension],
        ];
    }

    public function attributes()
    {
        return [
            'set_name' => __('tên bộ câu hỏi'),
            'subject_id' => __('môn thi'),
            'import_file' => __('file')
        ];
    }
}
