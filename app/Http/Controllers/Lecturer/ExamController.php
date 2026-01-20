<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Mail\ExamPublishedMail;
use App\Models\Exam;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ExamController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $exams = Exam::query()
            ->with(['classRoom', 'subject'])
            ->withCount('questions')
            ->where('created_by', $user->id)
            ->latest()
            ->get();

        return view('lecturer.exams.index', compact('exams'));
    }

    public function create()
    {
        $this->authorize('create', Exam::class);

        $classRooms = \App\Models\ClassRoom::query()
            ->with('subjects')
            ->orderBy('name')
            ->get();

        return view('lecturer.exams.create', compact('classRooms'));
    }

    public function store(StoreExamRequest $request)
    {
        $this->authorize('create', Exam::class);

        $exam = Exam::create([
            ...$request->validated(),
            'is_published' => (bool) $request->input('is_published'),
            'created_by' => $request->user()->id,
        ]);

        $shouldNotify = $request->boolean('notify_students');

        if ($exam->is_published && $shouldNotify) {
            $students = User::query()
                ->where('role', 'student')
                ->where('class_room_id', $exam->class_room_id)
                ->get();

            $exam->loadMissing('subject');
            $examsUrl = url('/student/exams');

            foreach ($students as $student) {
                try {
                    Mail::to($student->email)->send(new ExamPublishedMail($exam, $student, $examsUrl));

                    EmailLog::create([
                        'type' => 'exam_published',
                        'to_email' => $student->email,
                        'to_user_id' => $student->id,
                        'subject' => 'New exam published: '.$exam->title,
                        'status' => 'sent',
                        'meta' => [
                            'exam_id' => $exam->id,
                            'class_room_id' => $exam->class_room_id,
                            'subject_id' => $exam->subject_id,
                        ],
                        'sent_at' => now(),
                        'created_by' => $request->user()->id,
                    ]);
                } catch (\Throwable $exception) {
                    EmailLog::create([
                        'type' => 'exam_published',
                        'to_email' => $student->email,
                        'to_user_id' => $student->id,
                        'subject' => 'New exam published: '.$exam->title,
                        'status' => 'failed',
                        'error_message' => $exception->getMessage(),
                        'meta' => [
                            'exam_id' => $exam->id,
                            'class_room_id' => $exam->class_room_id,
                            'subject_id' => $exam->subject_id,
                        ],
                        'created_by' => $request->user()->id,
                    ]);
                }
            }
        }

        return redirect()
            ->route('lecturer.exams.edit', $exam)
            ->with('status', __('Exam created.'));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        $exam->load('questions.choices');

        $classRooms = \App\Models\ClassRoom::query()
            ->with('subjects')
            ->orderBy('name')
            ->get();

        return view('lecturer.exams.edit', compact('exam', 'classRooms'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $wasPublished = $exam->is_published;

        $exam->update([
            ...$request->validated(),
            'is_published' => (bool) $request->input('is_published'),
        ]);

        $shouldNotify = $request->boolean('notify_students');

        if (! $wasPublished && $exam->is_published && $shouldNotify) {
            $students = User::query()
                ->where('role', 'student')
                ->where('class_room_id', $exam->class_room_id)
                ->get();

            $exam->loadMissing('subject');
            $examsUrl = url('/student/exams');

            foreach ($students as $student) {
                try {
                    Mail::to($student->email)->send(new ExamPublishedMail($exam, $student, $examsUrl));

                    EmailLog::create([
                        'type' => 'exam_published',
                        'to_email' => $student->email,
                        'to_user_id' => $student->id,
                        'subject' => 'New exam published: '.$exam->title,
                        'status' => 'sent',
                        'meta' => [
                            'exam_id' => $exam->id,
                            'class_room_id' => $exam->class_room_id,
                            'subject_id' => $exam->subject_id,
                        ],
                        'sent_at' => now(),
                        'created_by' => $request->user()->id,
                    ]);
                } catch (\Throwable $exception) {
                    EmailLog::create([
                        'type' => 'exam_published',
                        'to_email' => $student->email,
                        'to_user_id' => $student->id,
                        'subject' => 'New exam published: '.$exam->title,
                        'status' => 'failed',
                        'error_message' => $exception->getMessage(),
                        'meta' => [
                            'exam_id' => $exam->id,
                            'class_room_id' => $exam->class_room_id,
                            'subject_id' => $exam->subject_id,
                        ],
                        'created_by' => $request->user()->id,
                    ]);
                }
            }
        }

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
