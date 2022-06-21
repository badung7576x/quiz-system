<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExcelExtension;

class ImportQuestionRequest extends FormRequest
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
            'question_file' => ['required', 'file', new ExcelExtension],
        ];
    }

    public function attributes()
    {
        return [
            'question_file' => 'file excel'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any())
                $validator->errors()->add('modal', 'Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
        });
    }
}
