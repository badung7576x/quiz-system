<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'id' => 'nullable|numeric',
            'code' => 'required_without:id|unique:teachers,code' . ($this->id ? ",$this->id" : ''),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fullname' => 'required_without:id',
            'email' => 'required_without:id|email|unique:teachers,email' . ($this->id ? ",$this->id" : ''),
            'password' => $this->id ? 'nullable|min:6' : 'required|min:6',
            'password_confirm' => 'required_without:id|same:password',
            'phone_number' => 'required_without:id',
            'date_of_birth' => 'required_without:id|date|before:today',
            'address' => 'nullable',
            'identity_number' => 'required_without:id|unique:teachers,identity_number' . ($this->id ? ",$this->id" : ''),
            'gender' => 'required',
            'role' => 'required',
            'subject_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'mã giáo viên',
            'avatar' => 'hình ảnh đại diện',
            'fullname' => 'họ và tên',
            'email' => 'email',
            'password' => 'mật khẩu',
            'password_confirm' => 'mật khẩu (xác nhận)',
            'phone_number' => 'số điện thoại',
            'date_of_birth' => 'ngày sinh',
            'title' => 'chức vụ',
            'address' => 'địa chỉ',
            'identity_number' => 'số CMND/CCCD',
            'gender' => 'giới tính',
            'role' => 'vai trò',
            'subject_id' => 'bộ môn giảng dạy'
        ];
    }

    public function messages()
    {
        return [
            'date_of_birth.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại',
        ];
    }
}
