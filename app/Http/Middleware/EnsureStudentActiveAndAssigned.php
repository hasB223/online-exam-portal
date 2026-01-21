<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentActiveAndAssigned
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isStudent()) {
            if (! $user->isActive() || ! $user->class_room_id) {
                return redirect()
                    ->route('pending')
                    ->with('status', __('Your account is pending approval.'));
            }
        }

        return $next($request);
    }
}
