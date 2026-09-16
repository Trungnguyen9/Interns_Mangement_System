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
            'status'             => 'required|in:Ongoing Interns,Completed Interns',
            'mentor_id'          => 'nullable|exists:mentor_profiles,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'             => 'Please enter the account name.',

            'name.unique'               => 'This account name already exists.',

            'email.required'            => 'Please enter the email address.',

            'email.email'               => 'Invalid email format.',

            'email.unique'              => 'This email is already registered.',

            'password.required'         => 'Please enter the password.',

            'password.min'              => 'The password must be at least :min characters.',

            'password.confirmed'        => 'Password confirmation does not match.',

            'start_date.required'       => 'Please select the start date.',

            'start_date.date'           => 'The start date is not a valid date.',

            'end_date.required'         => 'Please select the end date.',

            'end_date.date'             => 'The end date is not a valid date.',

            'end_date.after_or_equal'   => 'The end date must be on or after the start date.',

            'status.required'           => 'Please select a status.',

            'status.in'                 => 'Invalid status.',

            'mentor_id.exists'          => 'The selected mentor does not exist in the system.',
        ];
    }
}
