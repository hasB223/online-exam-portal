<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GradeAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isLecturer() ?? false;
    }

    public function rules(): array
    {
        return [
            'text_scores' => ['nullable', 'array'],
            'text_scores.*' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function (Validator $validator) {
            $attempt = $this->route('attempt');
            if (! $attempt) {
                return;
            }

            $attempt->loadMissing('exam.questions');

            foreach ($attempt->exam->questions as $question) {
                if ($question->type !== 'text') {
                    continue;
                }

                $score = $this->input("text_scores.{$question->id}");
                if ($score === null) {
                    continue;
                }

                if ((int) $score > $question->points) {
                    $validator->errors()->add("text_scores.{$question->id}", __('Score cannot exceed question points.'));
                }
            }
        });
    }
}
