<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamSetRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|numeric',
            'subject_id' => 'required|integer',
            'subject_content_ids' => 'required|array',
            'execute_time' => 'required|numeric',
            'total_question' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên đề thi',
            'type' => 'loại đề thi',
            'subject_id' => 'môn học',
            'subject_content_ids' => 'nội dung môn học',
            'execute_time' => 'thời gian làm bài',
            'total_question' => 'số lượng câu hỏi',
        ];
    }
}
