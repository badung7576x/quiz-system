<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
        $rule = [
            'subject_id' => 'required',
            'subject_content_id' => 'required',
            'level' => 'required',
            'type' => 'required',
            'score' => 'required',
            'content' => 'required|string',
        ];
        if ($this->type == QUESTION_MULTI_CHOICE) {
            $otherRule = [
                'answers' => 'required|array',
                'answers.*' => 'required|string',
                'correct_answer' => 'required|numeric',
            ];
            $rule = array_merge($rule, $otherRule);
        } else if ($this->type == QUESTION_TRUE_FALSE) {
            $otherRule = [
                'answers' => 'required|array',
                'answers.*' => 'required|string',
                'correct_answer' => 'required|array',
                'correct_answer.*' => 'required|numeric',
                'new_answers' => 'nullable|array',
                'new_answers.*' => 'required|string',
                'new_correct_answer' => 'nullable|array',
                'new_correct_answer.*' => 'required|numeric',
            ];
            $rule = array_merge($rule, $otherRule);
        }

        return $rule;
    }

    public function attributes()
    {
        $attributes = [
            'subject_id' => 'môn học',
            'subject_content_id' => 'nội dung môn học',
            'level' => 'mức độ câu hỏi',
            'type' => 'loại câu hỏi',
            'score' => 'điểm',
        ];
        if ($this->type == QUESTION_MULTI_CHOICE) {
            return array_merge($attributes, [
                'content' => 'nội dung câu hỏi',
                'answers' => 'các đáp án',
                'answers.*' => 'đáp án',
                'correct_answer' => 'đáp án đúng',
            ]);
        }

        if ($this->type == QUESTION_TRUE_FALSE) {
            return array_merge($attributes, [
                'content' => 'nội dung chính',
                'answers' => 'các câu hỏi',
                'answers.*' => 'câu hỏi',
                'correct_answer' => 'đáp án đúng',
                'correct_answer.*' => 'đáp án đúng',
                'content' => 'nội dung chính',
                'new_answers' => 'các câu hỏi',
                'new_answers.*' => 'câu hỏi',
                'new_correct_answer' => 'đáp án đúng',
                'new_correct_answer.*' => 'đáp án đúng',
            ]);
        }
    }
}
