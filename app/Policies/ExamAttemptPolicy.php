<?php

namespace App\Policies;

use App\Models\ExamAttempt;
use App\Models\User;

class ExamAttemptPolicy
{
    public function view(User $user, ExamAttempt $attempt): bool
    {
        if ($attempt->user_id === $user->id) {
            return true;
        }

        if ($user->isLecturer()) {
            return $attempt->exam?->created_by === $user->id;
        }

        return false;
    }

    public function submit(User $user, ExamAttempt $attempt): bool
    {
        return $attempt->user_id === $user->id && ! in_array($attempt->status, ['submitted', 'expired'], true);
    }

    public function grade(User $user, ExamAttempt $attempt): bool
    {
        return $user->isLecturer() && $attempt->exam?->created_by === $user->id;
    }
}
