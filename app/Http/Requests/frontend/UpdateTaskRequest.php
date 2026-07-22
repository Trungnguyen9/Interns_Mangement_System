<?php

namespace App\Http\Requests\frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
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
        $task = Auth::user()
            ->mentorProfile
            ->tasks()
            ->find($this->route('id'));

        $deadlineRule = ['required', 'date'];

        if ($task && $this->deadline != $task->deadline) {
            $deadlineRule[] = 'after_or_equal:today';
        }
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'deadline' => $deadlineRule,

            'priority' => [
                'required',
                'in:low,medium,high',
            ],

            'mentor_comment' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'action' => [
                'required',
                'in:save,doing,done',
            ],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề task.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'description.string' => 'Mô tả không hợp lệ.',

            'deadline.required' => 'Vui lòng chọn deadline.',
            'deadline.date' => 'Deadline không hợp lệ.',
            'deadline.after_or_equal' => 'Deadline không được nhỏ hơn ngày hiện tại.',

            'priority.required' => 'Vui lòng chọn mức ưu tiên.',
            'priority.in' => 'Mức ưu tiên không hợp lệ.',

            'mentor_comment.max' => 'Nhận xét không được vượt quá 1000 ký tự.',

            'action.required' => 'Thao tác không hợp lệ.',
            'action.in' => 'Thao tác không hợp lệ.',
        ];
    }
}
