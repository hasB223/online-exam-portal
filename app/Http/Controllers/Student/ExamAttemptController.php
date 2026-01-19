<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitAttemptRequest;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Services\ExamAttemptGuard;
use Illuminate\Support\Facades\DB;

class ExamAttemptController extends Controller
{
    public function __construct(private ExamAttemptGuard $guard)
    {
    }

    public function start(Exam $exam)
    {
        $this->authorize('view', $exam);

        if ($exam->class_room_id !== request()->user()->class_room_id) {
            abort(403);
        }

        $attempt = ExamAttempt::firstOrCreate(
            [
                'exam_id' => $exam->id,
                'user_id' => request()->user()->id,
            ],
            [
                'started_at' => now(),
                'ends_at' => $exam->duration_minutes ? now()->addMinutes($exam->duration_minutes) : null,
                'status' => 'in_progress',
            ]
        );

        $this->guard->enforceExpiry($attempt);

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

        $this->guard->enforceExpiry($attempt);

        $attempt->load(['exam.questions.choices']);

        $answers = $attempt->answers()
            ->get()
            ->keyBy('question_id');

        return view('student.attempts.show', compact('attempt', 'answers'));
    }

    public function submit(SubmitAttemptRequest $request, ExamAttempt $attempt)
    {
        $this->authorize('submit', $attempt);

        $this->guard->enforceExpiry($attempt);

        if ($attempt->status === 'expired') {
            return redirect()
                ->route('student.attempts.show', $attempt)
                ->with('status', __('Attempt expired.'));
        }

        $attempt->load('exam.questions.choices');

        DB::transaction(function () use ($attempt, $request) {
            $autoScore = 0;
            $autoTotal = 0;
            $textPending = 0;

            foreach ($attempt->exam->questions as $question) {
                $payload = $request->input("answers.{$question->id}", []);

                $selectedChoiceId = null;
                $textAnswer = null;

                if ($question->type === 'mcq') {
                    $autoTotal += $question->points;
                    $selectedChoiceId = $payload['selected_choice_id'] ?? null;

                    if ($selectedChoiceId) {
                        $validChoice = $question->choices->firstWhere('id', (int) $selectedChoiceId);
                        $selectedChoiceId = $validChoice?->id;
                        if ($validChoice?->is_correct) {
                            $autoScore += $question->points;
                        }
                    }
                } else {
                    $textAnswer = $payload['text_answer'] ?? null;
                    $textPending += 1;
                }

                Answer::updateOrCreate(
                    [
                        'exam_attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'selected_choice_id' => $selectedChoiceId,
                        'text_answer' => $textAnswer,
                    ]
                );
            }

            $attempt->update([
                'submitted_at' => now(),
                'status' => 'submitted',
                'auto_score' => $autoScore,
                'auto_total_points' => $autoTotal,
                'text_pending_count' => $textPending,
            ]);
        });

        return redirect()
            ->route('student.attempts.show', $attempt)
            ->with('status', __('Exam submitted.'));
    }
}
