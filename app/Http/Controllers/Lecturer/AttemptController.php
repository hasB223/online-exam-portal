<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeAttemptRequest;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Services\ExamAttemptGuard;
use Carbon\Carbon;
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

    public function export(Exam $exam)
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

        $today = Carbon::now()->format('Ymd');
        $filename = "exam_{$exam->id}_results_{$today}.csv";

        return response()->streamDownload(function () use ($students, $attemptsByStudent) {
            $output = fopen('php://output', 'w');

            $headers = [
                'student_name',
                'student_email',
                'status',
                'started_at',
                'submitted_at',
                'ends_at',
                'auto_score',
                'auto_total_points',
                'text_pending_count',
                'text_score',
                'text_total_points',
                'final_score',
                'final_total_points',
                'graded_at',
            ];

            $writeRow = function (array $row) use ($output) {
                $escaped = array_map(function ($value) {
                    $string = (string) $value;
                    $string = str_replace('"', '""', $string);
                    return "\"{$string}\"";
                }, $row);

                fwrite($output, implode(',', $escaped)."\n");
            };

            $writeRow($headers);

            foreach ($students as $student) {
                $attempt = $attemptsByStudent->get($student->id);
                $status = 'Not started';

                if ($attempt) {
                    if ($attempt->graded_at) {
                        $status = 'Graded';
                    } elseif ($attempt->status === 'expired') {
                        $status = 'Expired';
                    } elseif ($attempt->status === 'in_progress') {
                        $status = 'In progress';
                    } elseif ($attempt->status === 'submitted' && ($attempt->text_pending_count ?? 0) > 0) {
                        $status = 'Submitted (ungraded)';
                    } elseif ($attempt->status === 'submitted') {
                        $status = 'Submitted';
                    }
                }

                $writeRow([
                    $student->name,
                    $student->email,
                    $status,
                    $attempt?->started_at?->toDateTimeString() ?? '',
                    $attempt?->submitted_at?->toDateTimeString() ?? '',
                    $attempt?->ends_at?->toDateTimeString() ?? '',
                    $attempt?->auto_score ?? '',
                    $attempt?->auto_total_points ?? '',
                    $attempt?->text_pending_count ?? '',
                    $attempt?->text_score ?? '',
                    $attempt?->text_total_points ?? '',
                    $attempt?->final_score ?? '',
                    $attempt?->final_total_points ?? '',
                    $attempt?->graded_at?->toDateTimeString() ?? '',
                ]);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
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
