<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $exams = Exam::query()
            ->with('questions')
            ->when(! $user->isAdmin(), fn ($query) => $query->where('created_by', $user->id))
            ->latest()
            ->get();

        return view('lecturer.exams.index', compact('exams'));
    }

    public function create()
    {
        $this->authorize('create', Exam::class);

        return view('lecturer.exams.create');
    }

    public function store(StoreExamRequest $request)
    {
        $this->authorize('create', Exam::class);

        $exam = Exam::create([
            ...$request->validated(),
            'is_published' => (bool) $request->input('is_published'),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Exam created.'));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        $exam->load('questions.choices');

        return view('lecturer.exams.edit', compact('exam'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $exam->update([
            ...$request->validated(),
            'is_published' => (bool) $request->input('is_published'),
        ]);

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Exam updated.'));
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        $exam->delete();

        return redirect()
            ->route('lecturer.exams.index')
            ->with('status', __('Exam deleted.'));
    }
}
