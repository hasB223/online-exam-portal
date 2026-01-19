<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Exam;
use App\Models\Question;

class QuestionController extends Controller
{
    public function create(Exam $exam)
    {
        $this->authorize('update', $exam);

        return view('lecturer.questions.create', compact('exam'));
    }

    public function store(StoreQuestionRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $data = $request->validated();

        $question = $exam->questions()->create([
            'type' => $data['type'],
            'question_text' => $data['question_text'],
            'points' => $data['points'],
        ]);

        if ($data['type'] === 'mcq') {
            $choices = array_values(array_filter($data['choices'] ?? [], fn ($value) => $value !== null && $value !== ''));
            $correctIndex = (int) $data['correct_choice'];

            foreach ($choices as $index => $choiceText) {
                $question->choices()->create([
                    'text' => $choiceText,
                    'is_correct' => $index === $correctIndex,
                ]);
            }
        }

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Question added.'));
    }

    public function edit(Exam $exam, Question $question)
    {
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $this->authorize('update', $question);

        $question->load('choices');

        return view('lecturer.questions.edit', compact('exam', 'question'));
    }

    public function update(UpdateQuestionRequest $request, Exam $exam, Question $question)
    {
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $this->authorize('update', $question);

        $data = $request->validated();

        $question->update([
            'type' => $data['type'],
            'question_text' => $data['question_text'],
            'points' => $data['points'],
        ]);

        $question->choices()->delete();

        if ($data['type'] === 'mcq') {
            $choices = array_values(array_filter($data['choices'] ?? [], fn ($value) => $value !== null && $value !== ''));
            $correctIndex = (int) $data['correct_choice'];

            foreach ($choices as $index => $choiceText) {
                $question->choices()->create([
                    'text' => $choiceText,
                    'is_correct' => $index === $correctIndex,
                ]);
            }
        }

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Question updated.'));
    }

    public function destroy(Exam $exam, Question $question)
    {
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $this->authorize('delete', $question);

        $question->delete();

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Question deleted.'));
    }
}
