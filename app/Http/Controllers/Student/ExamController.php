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
            ->where('class_room_id', $user->class_room_id)
            ->withCount('questions')
            ->latest()
            ->get()
            ->filter(fn (Exam $exam) => $exam->isOpen());

        $attempts = $user->examAttempts()
            ->get()
            ->keyBy('exam_id');

        $statuses = [];

        foreach ($exams as $exam) {
            $attempt = $attempts->get($exam->id);

            if (! $attempt) {
                $statuses[$exam->id] = 'not_started';
                continue;
            }

            if ($attempt->ends_at && $attempt->status === 'in_progress' && now()->greaterThan($attempt->ends_at)) {
                $attempt->update(['status' => 'expired']);
            }

            $statuses[$exam->id] = $attempt->status;
        }

        return view('student.exams.index', compact('exams', 'attempts', 'statuses'));
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
