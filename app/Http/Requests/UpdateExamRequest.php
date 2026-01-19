<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() || $this->user()?->isLecturer();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'class_room_id' => ['required', 'exists:class_rooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $classRoomId = $this->input('class_room_id');
            $subjectId = $this->input('subject_id');

            if (! $classRoomId || ! $subjectId) {
                return;
            }

            $exists = \Illuminate\Support\Facades\DB::table('class_room_subject')
                ->where('class_room_id', $classRoomId)
                ->where('subject_id', $subjectId)
                ->exists();

            if (! $exists) {
                $validator->errors()->add('subject_id', __('Subject must belong to the selected class.'));
            }
        });
    }
}
