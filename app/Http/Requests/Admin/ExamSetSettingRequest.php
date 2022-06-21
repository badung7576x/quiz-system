<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamSetSettingRequest extends FormRequest
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
            'is_display_top' => 'boolean',
            'top_left' => 'required_if:is_display_top,1',
            'top_right' => 'required_if:is_display_top,1',
            'is_display_center' => 'boolean',
            'center' => 'required_if:is_display_center,1',
            'is_display_bottom' => 'boolean',
            'bottom' => 'required_if:is_display_bottom,1'
        ];
    }

    public function attributes()
    {
        return [
            'top_left' => 'nội dung ①',
            'top_right' => 'nội dung ②',
            'center' => 'nội dung ③',
            'bottom' => 'nội dung ⑤'
        ];
    }
    

    public function messages()
    {
        return [
            'top_left.required_if' => 'Trường nội dung ① phải nhập nội dung để được hiển thị.',
            'top_right.required_if' => 'Trường nội dung ② phải nhập nội dung để được hiển thị.',
            'center.required_if' => 'Trường nội dung ③ phải nhập nội dung để được hiển thị.',
            'bottom.required_if' => 'Trường nội dung ⑤ phải nhập nội dung để được hiển thị.',
        ];
    }
}
