<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with('classRoom')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $classRooms = ClassRoom::query()
            ->orderBy('name')
            ->get();

        return view('admin.users.create', compact('classRooms'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($data['role'] !== 'student') {
            $data['class_room_id'] = null;
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User created.'));
    }

    public function edit(User $user)
    {
        $classRooms = ClassRoom::query()
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact('user', 'classRooms'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['role'] !== 'student') {
            $data['class_room_id'] = null;
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User updated.'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User deleted.'));
    }
}
