<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Lecturer\ExamController as LecturerExamController;
use App\Http\Controllers\Lecturer\QuestionController as LecturerQuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ExamAttemptController;
use App\Http\Controllers\Student\ExamController as StudentExamController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('classes', \App\Http\Controllers\Admin\ClassRoomController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
});

Route::middleware(['auth', 'role:lecturer,admin'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::view('/', 'lecturer.dashboard')->name('dashboard');
    Route::resource('exams', LecturerExamController::class)->except(['show']);
    Route::get('exams/{exam}/questions/create', [LecturerQuestionController::class, 'create'])->name('questions.create');
    Route::post('exams/{exam}/questions', [LecturerQuestionController::class, 'store'])->name('questions.store');
    Route::get('exams/{exam}/questions/{question}/edit', [LecturerQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('exams/{exam}/questions/{question}', [LecturerQuestionController::class, 'update'])->name('questions.update');
    Route::delete('exams/{exam}/questions/{question}', [LecturerQuestionController::class, 'destroy'])->name('questions.destroy');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::view('/', 'student.dashboard')->name('dashboard');
    Route::get('/exams', [StudentExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{exam}', [StudentExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/{exam}/start', [ExamAttemptController::class, 'start'])->name('exams.start');
    Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('attempts.show');
    Route::post('/attempts/{attempt}/submit', [ExamAttemptController::class, 'submit'])->name('attempts.submit');
});

require __DIR__.'/auth.php';
