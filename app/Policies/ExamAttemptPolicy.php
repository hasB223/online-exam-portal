<?php

namespace App\Policies;

use App\Models\ExamAttempt;
use App\Models\User;

class ExamAttemptPolicy
{
    public function view(User $user, ExamAttempt $attempt): bool
    {
        return $attempt->user_id === $user->id;
    }

    public function submit(User $user, ExamAttempt $attempt): bool
    {
        return $attempt->user_id === $user->id && ! $attempt->isSubmitted();
    }
}
