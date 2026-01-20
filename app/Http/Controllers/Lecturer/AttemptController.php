<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeAttemptRequest;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\DB;

class AttemptController extends Controller
{
    public function index(Exam $exam)
    {
        $this->authorize('update', $exam);

        $attempts = ExamAttempt::query()
            ->with(['student', 'grader'])
            ->where('exam_id', $exam->id)
            ->latest('submitted_at')
            ->get();

        return view('lecturer.attempts.index', compact('exam', 'attempts'));
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
