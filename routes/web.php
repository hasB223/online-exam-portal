<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Lecturer\ExamController as LecturerExamController;
use App\Http\Controllers\Lecturer\QuestionController as LecturerQuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ExamAttemptController;
use App\Http\Controllers\Student\ExamController as StudentExamController;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ms'], true)) {
        Session::put('locale', $locale);
    }

    return back();
})->name('locale.switch');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isLecturer()) {
        return redirect()->route('lecturer.dashboard');
    }

    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pending', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    if (! $user->isStudent()) {
        return redirect()->route('dashboard');
    }

    if ($user->isActive() && $user->class_room_id) {
        return redirect()->route('student.dashboard');
    }

    return view('pending', compact('user'));
})->middleware('auth')->name('pending');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        $announcements = \App\Models\Announcement::visibleTo(request()->user())->get();
        return view('admin.dashboard', compact('announcements'));
    })->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('classes', \App\Http\Controllers\Admin\ClassRoomController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class)->except(['show', 'destroy']);
    Route::get('email-logs', [\App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('email-logs.index');
});

Route::middleware(['auth', 'role:lecturer,admin'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/', function () {
        $user = request()->user();

        $announcements = \App\Models\Announcement::visibleTo($user)->get();

        $publishedCount = Exam::query()
            ->where('created_by', $user->id)
            ->where('is_published', true)
            ->count();

        $draftCount = Exam::query()
            ->where('created_by', $user->id)
            ->where('is_published', false)
            ->count();

        $needsGradingCount = ExamAttempt::query()
            ->where('status', 'submitted')
            ->whereNull('graded_at')
            ->where('text_pending_count', '>', 0)
            ->whereHas('exam', fn ($query) => $query->where('created_by', $user->id))
            ->count();

        $recentAttempts = ExamAttempt::query()
            ->with(['exam:id,title,created_by', 'student:id,name'])
            ->where('status', 'submitted')
            ->whereHas('exam', fn ($query) => $query->where('created_by', $user->id))
            ->orderByDesc('submitted_at')
            ->limit(8)
            ->get();

        return view('lecturer.dashboard', compact(
            'announcements',
            'publishedCount',
            'draftCount',
            'needsGradingCount',
            'recentAttempts'
        ));
    })->name('dashboard');
    Route::resource('exams', LecturerExamController::class)->except(['show']);
    Route::get('exams/{exam}/clone', [LecturerExamController::class, 'clone'])->name('exams.clone');
    Route::post('exams/{exam}/clone', [LecturerExamController::class, 'storeClone'])->name('exams.clone.store');
    Route::get('exams/{exam}/attempts', [\App\Http\Controllers\Lecturer\AttemptController::class, 'index'])->name('exams.attempts.index');
    Route::get('attempts/{attempt}', [\App\Http\Controllers\Lecturer\AttemptController::class, 'show'])->name('attempts.show');
    Route::put('attempts/{attempt}', [\App\Http\Controllers\Lecturer\AttemptController::class, 'update'])->name('attempts.update');
    Route::get('exams/{exam}/questions/create', [LecturerQuestionController::class, 'create'])->name('questions.create');
    Route::post('exams/{exam}/questions', [LecturerQuestionController::class, 'store'])->name('questions.store');
    Route::get('exams/{exam}/questions/{question}/edit', [LecturerQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('exams/{exam}/questions/{question}', [LecturerQuestionController::class, 'update'])->name('questions.update');
    Route::delete('exams/{exam}/questions/{question}', [LecturerQuestionController::class, 'destroy'])->name('questions.destroy');
});

Route::middleware(['auth', 'role:student', 'student.active'])->prefix('student')->name('student.')->group(function () {
    Route::get('/', function () {
        $announcements = \App\Models\Announcement::visibleTo(request()->user())->get();
        return view('student.dashboard', compact('announcements'));
    })->name('dashboard');
    Route::get('/exams', [StudentExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{exam}', [StudentExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/{exam}/start', [ExamAttemptController::class, 'start'])->name('exams.start');
    Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('attempts.show');
    Route::post('/attempts/{attempt}/submit', [ExamAttemptController::class, 'submit'])->name('attempts.submit');
});

require __DIR__.'/auth.php';
