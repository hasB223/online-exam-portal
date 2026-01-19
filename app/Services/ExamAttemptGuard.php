<?php

namespace App\Services;

use App\Models\ExamAttempt;

class ExamAttemptGuard
{
    public function enforceExpiry(ExamAttempt $attempt): ExamAttempt
    {
        if ($attempt->ends_at && $attempt->status === 'in_progress' && now()->greaterThan($attempt->ends_at)) {
            $attempt->update([
                'status' => 'expired',
            ]);
        }

        return $attempt;
    }
}
