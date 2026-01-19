<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitAttemptRequest;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\DB;

class ExamAttemptController extends Controller
{
    public function start(Exam $exam)
    {
        $this->authorize('view', $exam);

        $attempt = ExamAttempt::firstOrCreate(
            [
                'exam_id' => $exam->id,
                'user_id' => request()->user()->id,
            ],
            [
                'started_at' => now(),
            ]
        );

        if ($attempt->isSubmitted()) {
            return redirect()
                ->route('student.attempts.show', $attempt)
                ->with('status', __('Exam already submitted.'));
        }

        return redirect()->route('student.attempts.show', $attempt);
    }

    public function show(ExamAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        $attempt->load(['exam.questions']);

        $answers = $attempt->answers()
            ->get()
            ->keyBy('question_id');

        return view('student.attempts.show', compact('attempt', 'answers'));
    }

    public function submit(SubmitAttemptRequest $request, ExamAttempt $attempt)
    {
        $this->authorize('submit', $attempt);

        $attempt->load('exam.questions');

        DB::transaction(function () use ($attempt, $request) {
            $score = 0;
            $totalPoints = 0;

            foreach ($attempt->exam->questions as $question) {
                $totalPoints += $question->points;
                $selected = $request->input("answers.{$question->id}");
                $isCorrect = $selected !== null && (int) $selected === $question->correct_option;
                $pointsAwarded = $isCorrect ? $question->points : 0;
                $score += $pointsAwarded;

                Answer::updateOrCreate(
                    [
                        'exam_attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'selected_option' => $selected,
                        'is_correct' => $isCorrect,
                        'points_awarded' => $pointsAwarded,
                    ]
                );
            }

            $attempt->update([
                'submitted_at' => now(),
                'score' => $score,
                'total_points' => $totalPoints,
            ]);
        });

        return redirect()
            ->route('student.attempts.show', $attempt)
            ->with('status', __('Exam submitted.'));
    }
}
