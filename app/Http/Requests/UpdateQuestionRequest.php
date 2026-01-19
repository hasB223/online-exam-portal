<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() || $this->user()?->isLecturer();
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:mcq,text'],
            'question_text' => ['required', 'string'],
            'choices' => ['nullable', 'array'],
            'choices.*' => ['nullable', 'string', 'max:255'],
            'correct_choice' => ['nullable', 'integer', 'min:0', 'max:5'],
            'points' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');

            if ($type === 'mcq') {
                $choices = array_values(array_filter((array) $this->input('choices'), fn ($value) => $value !== null && $value !== ''));
                $correct = $this->input('correct_choice');

                if (count($choices) < 2 || count($choices) > 6) {
                    $validator->errors()->add('choices', __('MCQ choices must be between 2 and 6.'));
                }

                if ($correct === null || ! array_key_exists($correct, $choices)) {
                    $validator->errors()->add('correct_choice', __('Select exactly one correct choice.'));
                }
            }

            if ($type === 'text' && ! empty($this->input('choices'))) {
                $validator->errors()->add('choices', __('Text questions should not have choices.'));
            }
        });
    }
}
