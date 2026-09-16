<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Intern_profiles;
use Illuminate\Validation\Rule;

class updateInternRequest extends FormRequest
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
            // 'name'               => 'required|string|max:255',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->user_id),
            ],
            'full_name'          => 'nullable|string|max:255',
            // 'email'              => 'required|email|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'school'             => 'nullable|string|max:255',
            'academic_year'      => 'nullable|string|max:50',
            'desired_technology' => 'nullable|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date', // The end date must be greater than or equal to the start date.
            'status'             => 'required|in:Ongoing Interns,Completed Interns',
            'mentor_id'          => 'nullable|exists:mentor_profiles,id',
        ];
    }
    public function messages(): array
    { 
        return [
            'name.required'               => 'Please enter the account name.',
            'name.unique'                 => 'This account name already exists.',
            'name.max'                    => 'The account name must not exceed 255 characters.',
            'full_name.max'               => 'The full name must not exceed 255 characters.',
            'email.required'              => 'Please enter an email address.',
            'email.email'                 => 'The email format is invalid.',
            'email.max'                   => 'The email must not exceed 255 characters.',
            'email.unique'                => 'This email is already registered.',
            'start_date.required'         => 'Please select a start date.',
            'start_date.date'             => 'The start date is not in a valid date format.',
            'end_date.required'           => 'Please select an end date.',
            'end_date.date'               => 'The end date is not in a valid date format.',
            'end_date.after_or_equal'     => 'The end date must be greater than or equal to the start date.',
            'status.required'             => 'Please select a status.',
            'status.in'                   => 'The selected status is invalid.',
            'mentor_id.exists'            => 'The selected mentor does not exist in the system.',
        ];
    }
}
