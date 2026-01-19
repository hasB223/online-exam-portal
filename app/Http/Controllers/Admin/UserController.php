<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function update(UpdateUserRoleRequest $request, User $user)
    {
        $user->update([
            'role' => $request->validated('role'),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('Role updated.'));
    }
}
