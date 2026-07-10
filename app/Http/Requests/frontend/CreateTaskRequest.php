<?php

namespace App\Http\Requests\frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
    public function rules()
    {
        return [

            'title' => 'required|max:255',

            'description' => 'nullable',

            'intern_id' => 'required|exists:intern_profiles,id',

            'priority' => 'required|in:low,medium,high',

            'deadline' => 'required|date|after_or_equal:today',

        ];
    }
}
