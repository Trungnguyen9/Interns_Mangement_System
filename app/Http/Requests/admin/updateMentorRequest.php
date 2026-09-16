<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateMentorRequest extends FormRequest
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
            'department'         => 'nullable|string|max:255',
            'position'           => 'nullable|string|max:255',
            'max_interns'         => 'nullable|integer|min:1'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'               => 'Please enter the account name.',
            'name.unique'                 => 'This account name already exists.',
            'email.required'              => 'Please enter an email address.',
            'email.email'                 => 'The email format is invalid.',
            'email.unique'                => 'This email is already registered.',
            'max_interns.integer'          => 'The number of interns must be an integer.',
            'max_interns.min'              => 'The number of interns must be at least 1.',
        ];
    }
}
