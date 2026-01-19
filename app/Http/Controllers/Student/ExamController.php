<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $exams = Exam::query()
            ->where('is_published', true)
            ->withCount('questions')
            ->latest()
            ->get()
            ->filter(fn (Exam $exam) => $exam->isOpen());

        $attempts = $user->examAttempts()
            ->get()
            ->keyBy('exam_id');

        return view('student.exams.index', compact('exams', 'attempts'));
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);

        $exam->loadCount('questions');

        $attempt = $exam->attempts()
            ->where('user_id', request()->user()->id)
            ->first();

        return view('student.exams.show', compact('exam', 'attempt'));
    }
}
