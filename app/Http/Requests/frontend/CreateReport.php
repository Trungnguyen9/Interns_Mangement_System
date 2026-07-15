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
                            $fail("Link '{$link}' không phải là URL hợp lệ.");
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
            'week_start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'week_start_date.date' => 'Ngày bắt đầu không hợp lệ.',

            'week_end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'week_end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'week_end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',

            'completed_tasks.required' => 'Vui lòng nhập công việc đã hoàn thành.',
            'completed_tasks.max' => 'Công việc đã hoàn thành không được vượt quá 3000 ký tự.',

            'difficulties.max' => 'Phần khó khăn không được vượt quá 2000 ký tự.',

            'next_plan.required' => 'Vui lòng nhập kế hoạch tuần sau.',
            'next_plan.max' => 'Kế hoạch tuần sau không được vượt quá 3000 ký tự.',

            'reference_links.max' => 'Link tham khảo không được vượt quá 1000 ký tự.',
        ];
    }
}
