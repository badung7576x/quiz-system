<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentRequest extends FormRequest
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
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::in(['MALE', 'FEMALE'])],
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
            'last_name' => 'họ và tên đệm',
            'first_name' => 'tên',
            'date_of_birth' => 'ngày sinh',
            'gender' => 'giới tính'
        ];
    }
}
