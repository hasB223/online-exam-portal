<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;

class ExamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLecturer();
    }

    public function view(User $user, Exam $exam): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isLecturer()) {
            return $exam->created_by === $user->id;
        }

        if ($user->isStudent()) {
            return $exam->class_room_id === $user->class_room_id && $exam->isOpen();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLecturer();
    }

    public function update(User $user, Exam $exam): bool
    {
        return $user->isAdmin() || $exam->created_by === $user->id;
    }

    public function delete(User $user, Exam $exam): bool
    {
        return $user->isAdmin() || $exam->created_by === $user->id;
    }
}
