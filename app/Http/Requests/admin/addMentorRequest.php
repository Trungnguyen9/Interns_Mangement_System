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
            'name.required'               => 'Please enter the account name.',
            'name.unique'                 => 'This account name already exists.',
            'email.required'              => 'Please enter an email address.',
            'email.email'                 => 'The email format is invalid.',
            'email.unique'                => 'This email is already registered.',
            'password.required'           => 'Please enter a password.',
            'password.min'                => 'The password must be at least :min characters long.',
            'password.confirmed'          => 'Password confirmation does not match.',
            'max_interns.integer'          => 'The number of interns must be an integer.',
            'max_interns.min'              => 'The number of interns must be at least 1.',
        ];
    }
}
