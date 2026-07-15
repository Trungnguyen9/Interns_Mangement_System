<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class addInternRequest extends FormRequest
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
            'school'             => 'nullable|string|max:255',
            'academic_year'      => 'nullable|string|max:50',
            'desired_technology' => 'nullable|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date', 
            'status'             => 'required|in:Đang thực tập,Đã hoàn thành',
            'mentor_id'          => 'nullable|exists:mentor_profiles,id', 
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
            'start_date.required'         => 'Vui lòng chọn Ngày bắt đầu.',
            'start_date.date'             => 'Ngày bắt đầu không đúng định dạng ngày tháng.',
            'end_date.required'           => 'Vui lòng chọn Ngày kết thúc.',
            'end_date.date'               => 'Ngày kết thúc không đúng định dạng ngày tháng.',
            'end_date.after_or_equal'     => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
            'status.required'             => 'Vui lòng chọn Trạng thái.',
            'status.in'                   => 'Trạng thái không hợp lệ.',
            'mentor_id.exists'            => 'Mentor được chọn không tồn tại trong hệ thống.',
        ];
    }
}
