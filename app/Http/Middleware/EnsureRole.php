<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();
        $allowed = array_map('trim', explode(',', $roles));

        if (! $user || ! in_array($user->role, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
