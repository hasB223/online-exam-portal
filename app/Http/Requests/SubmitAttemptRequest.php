<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isStudent() ?? false;
    }

    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*.selected_choice_id' => ['nullable', 'integer', 'exists:choices,id'],
            'answers.*.text_answer' => ['nullable', 'string'],
        ];
    }
}
