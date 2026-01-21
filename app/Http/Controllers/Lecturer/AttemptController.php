<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeAttemptRequest;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Services\ExamAttemptGuard;
use Illuminate\Support\Facades\DB;

class AttemptController extends Controller
{
    public function index(Exam $exam)
    {
        $this->authorize('update', $exam);

        $students = User::query()
            ->where('role', 'student')
            ->where('class_room_id', $exam->class_room_id)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $attemptsByStudent = ExamAttempt::query()
            ->where('exam_id', $exam->id)
            ->get()
            ->keyBy('user_id');

        $guard = app(ExamAttemptGuard::class);

        $attemptsByStudent->each(function (ExamAttempt $attempt) use ($guard) {
            $guard->enforceExpiry($attempt);
        });

        $students = $students
            ->sortByDesc(function (User $student) use ($attemptsByStudent) {
                $attempt = $attemptsByStudent->get($student->id);
                return $attempt?->submitted_at?->timestamp ?? 0;
            })
            ->values();

        $submittedCount = $attemptsByStudent->filter(function (ExamAttempt $attempt) {
            return $attempt->status === 'submitted' || $attempt->submitted_at !== null;
        })->count();

        return view('lecturer.attempts.index', compact('exam', 'students', 'attemptsByStudent', 'submittedCount'));
    }

    public function show(ExamAttempt $attempt)
    {
        $this->authorize('grade', $attempt);

        $attempt->load([
            'exam.questions.choices',
            'student',
            'answers',
        ]);

        $answers = $attempt->answers->keyBy('question_id');

        return view('lecturer.attempts.show', compact('attempt', 'answers'));
    }

    public function update(GradeAttemptRequest $request, ExamAttempt $attempt)
    {
        $this->authorize('grade', $attempt);

        $attempt->load('exam.questions');

        $data = $request->validated();

        DB::transaction(function () use ($attempt, $data) {
            $textScore = 0;
            $textTotal = 0;

            foreach ($attempt->exam->questions as $question) {
                if ($question->type !== 'text') {
                    continue;
                }

                $textTotal += $question->points;
                $score = (int) ($data['text_scores'][$question->id] ?? 0);
                $textScore += $score;

                $attempt->answers()
                    ->where('question_id', $question->id)
                    ->update(['text_score' => $score]);
            }

            $attempt->update([
                'text_score' => $textScore,
                'text_total_points' => $textTotal,
                'final_score' => ($attempt->auto_score ?? 0) + $textScore,
                'final_total_points' => ($attempt->auto_total_points ?? 0) + $textTotal,
                'graded_at' => now(),
                'graded_by' => request()->user()->id,
            ]);
        });

        return redirect()
            ->route('lecturer.attempts.show', $attempt)
            ->with('status', __('Grading saved.'));
    }
}
