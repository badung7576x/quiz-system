<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'subject_contents' => 'required|array',
            'subject_contents.*' => 'required|string|max:150',
            'new_subject_contents' => 'nullable|array',
            'new_subject_contents.*' => 'nullable|string|max:150',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'tên môn học',
            'description' => 'mô tả',
            'subject_contents.*' => 'nội dung môn học',
            'new_subject_contents.*' => 'nội dung môn học',
        ];
    }
}
