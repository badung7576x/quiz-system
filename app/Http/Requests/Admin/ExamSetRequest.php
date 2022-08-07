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
            'code' => 'required|string|max:10',
            'num_of_set' => 'required|numeric|gt:0',
            'name' => 'required|string|max:255',
            'type' => 'required|numeric',
            'subject_id' => 'required|integer',
            'subject_content_ids' => 'required|array',
            'question_types' => 'required|array',
            'execute_time' => 'required|numeric|min:1',
            'total_question' => 'required|integer|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'mã đề thi',
            'num_of_set' => 'số lượng đề thi',
            'name' => 'tên đề thi',
            'type' => 'loại đề thi',
            'subject_id' => 'môn học',
            'subject_content_ids' => 'nội dung môn học',
            'question_types' => 'dạng câu hỏi',
            'execute_time' => 'thời gian làm bài',
            'total_question' => 'số lượng câu hỏi',
        ];
    }
}
