<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'subject_id' => 'required',
            'subject_content_id' => 'required',
            'level' => 'required',
            'type' => 'required',
            'score' => 'required',
            'content' => 'required|string',
            'answers' => 'required|array',
            'answers.*' => 'required',
            'correct_answer' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'subject_id' => 'môn học',
            'subject_content_id' => 'nội dung môn học',
            'level' => 'mức độ câu hỏi',
            'type' => 'loại câu hỏi',
            'score' => 'điểm',
            'content' => 'nội dung câu hỏi',
            'answers' => 'các đáp án',
            'answers.*' => 'đáp án',
            'correct_answer' => 'đáp án đúng',
        ];
    }
}