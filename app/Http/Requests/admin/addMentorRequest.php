<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class addMentorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'               => 'required|string|max:255|unique:users,name',
            'full_name'          => 'nullable|string|max:255',
            'email'              => 'required|email|max:255|unique:users,email',
            'password'           => 'required|string|min:8|confirmed',
            'department'         => 'nullable|string|max:255',
            'position'           => 'nullable|string|max:255',
            'max_interns'         => 'nullable|integer|min:1'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'               => 'Vui lòng nhập Tên tài khoản.',
            'name.unique'                 => 'Tên tài khoản này đã tồn tại.',
            'email.required'              => 'Vui lòng nhập địa chỉ Email.',
            'email.email'                 => 'Định dạng Email không hợp lệ.',
            'email.unique'                => 'Email này đã được đăng ký.',
            'password.required'           => 'Vui lòng nhập Mật khẩu.',
            'password.min'                => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'          => 'Xác nhận mật khẩu không trùng khớp.',
            'max_interns.integer'          => 'Số lượng sinh viên thực tập phải là một số nguyên.',
            'max_interns.min'              => 'Số lượng sinh viên thực tập phải lớn hơn hoặc bằng 1.',
        ];
    }
}
