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

        $exam->questions()->create($request->validated());

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

        return view('lecturer.questions.edit', compact('exam', 'question'));
    }

    public function update(UpdateQuestionRequest $request, Exam $exam, Question $question)
    {
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $this->authorize('update', $question);

        $question->update($request->validated());

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
