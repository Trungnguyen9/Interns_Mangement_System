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
            'title.required' => 'Please enter the task title.',
            'title.max' => 'The title must not exceed 255 characters.',

            'description.string' => 'Invalid description.',

            'deadline.required' => 'Please select a deadline.',
            'deadline.date' => 'Invalid deadline.',
            'deadline.after_or_equal' => 'The deadline cannot be earlier than the current date.',

            'priority.required' => 'Please select a priority level.',
            'priority.in' => 'Invalid priority level.',

            'mentor_comment.max' => 'Comments must not exceed 1000 characters.',

            'action.required' => 'Invalid action.',
            'action.in' => 'Invalid action.',
        ];
    }
}
