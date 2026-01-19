<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $lecturer = User::updateOrCreate(
            ['email' => 'lecturer@example.com'],
            [
                'name' => 'Lecturer User',
                'role' => 'lecturer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $classRoom = ClassRoom::create([
            'name' => 'Class A',
            'code' => 'CLASSA',
        ]);

        $studentOne = User::updateOrCreate(
            ['email' => 'student1@example.com'],
            [
                'name' => 'Student One',
                'role' => 'student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'class_room_id' => $classRoom->id,
            ]
        );

        $studentTwo = User::updateOrCreate(
            ['email' => 'student2@example.com'],
            [
                'name' => 'Student Two',
                'role' => 'student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'class_room_id' => $classRoom->id,
            ]
        );

        $subject = Subject::create([
            'name' => 'Fundamentals of Web',
            'code' => 'WEB101',
        ]);

        $classRoom->subjects()->sync([$subject->id]);

        $exam = Exam::create([
            'title' => 'Intro Assessment',
            'description' => 'Basics of HTML, CSS, and web concepts.',
            'subject_id' => $subject->id,
            'class_room_id' => $classRoom->id,
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDays(3),
            'duration_minutes' => 45,
            'is_published' => true,
            'created_by' => $lecturer->id,
        ]);

        $mcqOne = Question::create([
            'exam_id' => $exam->id,
            'type' => 'mcq',
            'question_text' => 'Which tag is used for the largest heading in HTML?',
            'points' => 2,
        ]);

        Choice::create(['question_id' => $mcqOne->id, 'text' => '<h1>', 'is_correct' => true]);
        Choice::create(['question_id' => $mcqOne->id, 'text' => '<p>', 'is_correct' => false]);
        Choice::create(['question_id' => $mcqOne->id, 'text' => '<div>', 'is_correct' => false]);
        Choice::create(['question_id' => $mcqOne->id, 'text' => '<span>', 'is_correct' => false]);

        $mcqTwo = Question::create([
            'exam_id' => $exam->id,
            'type' => 'mcq',
            'question_text' => 'Which CSS property controls text size?',
            'points' => 2,
        ]);

        Choice::create(['question_id' => $mcqTwo->id, 'text' => 'font-size', 'is_correct' => true]);
        Choice::create(['question_id' => $mcqTwo->id, 'text' => 'text-style', 'is_correct' => false]);
        Choice::create(['question_id' => $mcqTwo->id, 'text' => 'letter-space', 'is_correct' => false]);
        Choice::create(['question_id' => $mcqTwo->id, 'text' => 'font-weight', 'is_correct' => false]);

        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Explain the purpose of semantic HTML in one or two sentences.',
            'points' => 3,
        ]);
    }
}
