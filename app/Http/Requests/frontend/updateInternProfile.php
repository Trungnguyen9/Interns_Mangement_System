<?php

namespace App\Http\Requests\frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateInternProfile extends FormRequest
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
            'full_name'          => 'required|string|max:255',
            'school'             => 'nullable|string|max:255',
            'academic_year'      => 'nullable|string|max:50',
            'desired_technology' => 'nullable|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date', // The end date must be greater than or equal to the start date.
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'               => 'Please enter the account name.',
            'name.unique'                 => 'This account name already exists.',
            'name.max'                    => 'The account name must not exceed 255 characters.',
            'full_name.required'          => 'Please enter the full name.',
            'full_name.max'               => 'The full name must not exceed 255 characters.',
            'start_date.required'         => 'Please select a start date.',
            'start_date.date'             => 'The start date is not in a valid date format.',
            'end_date.required'           => 'Please select an end date.',
            'end_date.date'               => 'The end date is not in a valid date format.',
            'end_date.after_or_equal'     => 'The end date must be greater than or equal to the start date.',
            'mentor_id.exists'            => 'The selected mentor does not exist in the system.',
        ];
    }
}
 