<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    public function update(User $user, Question $question): bool
    {
        return $user->isAdmin() || $question->exam->created_by === $user->id;
    }

    public function delete(User $user, Question $question): bool
    {
        return $user->isAdmin() || $question->exam->created_by === $user->id;
    }
}
