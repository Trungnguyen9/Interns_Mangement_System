<?php

namespace App\Http\Requests\frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReport extends FormRequest
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
            'week_start_date' => [
                'required',
                'date',
            ],

            'week_end_date' => [
                'required',
                'date',
                'after_or_equal:week_start_date',
            ],

            'completed_tasks' => [
                'required',
                'string',
                'max:3000',
            ],

            'difficulties' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'next_plan' => [
                'required',
                'string',
                'max:3000',
            ],

            'reference_links' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $links = array_filter(array_map('trim', explode(',', $value)));

                    foreach ($links as $link) {
                        if (!filter_var($link, FILTER_VALIDATE_URL)) {
                            $fail("Link '{$link}' is not a valid URL.");
                        }
                    }
                },
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'week_start_date.required' => 'Please select a start date.',
            'week_start_date.date' => 'The start date is invalid.',

            'week_end_date.required' => 'Please select an end date.',
            'week_end_date.date' => 'The end date is invalid.',
            'week_end_date.after_or_equal' => 'The end date must be greater than or equal to the start date.',

            'completed_tasks.required' => 'Please enter completed tasks.',
            'completed_tasks.max' => 'Completed tasks must not exceed 3000 characters.',

            'difficulties.max' => 'Difficulties must not exceed 2000 characters.',

            'next_plan.required' => 'Please enter the next week plan.',
            'next_plan.max' => 'The next week plan must not exceed 3000 characters.',

            'reference_links.max' => 'Reference links must not exceed 1000 characters.',
        ];
    }
} 
