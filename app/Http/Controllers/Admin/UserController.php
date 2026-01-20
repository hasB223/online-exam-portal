<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\AccountCreatedMail;
use App\Mail\AccountUpdatedMail;
use App\Models\ClassRoom;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
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

        $user = User::create($data);

        $loginUrl = url('/login');
        $token = Password::broker()->createToken($user);
        $setPasswordUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
        $className = $user->classRoom?->name;

        try {
            Mail::to($user->email)->send(new AccountCreatedMail($user, $setPasswordUrl, $loginUrl, $className));

            EmailLog::create([
                'type' => 'account_created',
                'to_email' => $user->email,
                'to_user_id' => $user->id,
                'subject' => 'Your account was created',
                'status' => 'sent',
                'meta' => [
                    'role' => $user->role,
                    'class_room_id' => $user->class_room_id,
                    'action' => 'created',
                ],
                'sent_at' => now(),
                'created_by' => $request->user()->id,
            ]);
        } catch (\Throwable $exception) {
            EmailLog::create([
                'type' => 'account_created',
                'to_email' => $user->email,
                'to_user_id' => $user->id,
                'subject' => 'Your account was created',
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'meta' => [
                    'role' => $user->role,
                    'class_room_id' => $user->class_room_id,
                    'action' => 'created',
                ],
                'created_by' => $request->user()->id,
            ]);
        }

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
        $originalRole = $user->role;
        $originalClassRoomId = $user->class_room_id;

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

        $roleChanged = $user->role !== $originalRole;
        $classChanged = $user->class_room_id !== $originalClassRoomId;

        if ($roleChanged || $classChanged) {
            $loginUrl = url('/login');
            $className = $user->classRoom?->name;

            try {
                Mail::to($user->email)->send(new AccountUpdatedMail($user, $loginUrl, $className));

                EmailLog::create([
                    'type' => 'role_assigned',
                    'to_email' => $user->email,
                    'to_user_id' => $user->id,
                    'subject' => 'Your account details were updated',
                    'status' => 'sent',
                    'meta' => [
                        'role' => $user->role,
                        'class_room_id' => $user->class_room_id,
                        'action' => 'updated',
                    ],
                    'sent_at' => now(),
                    'created_by' => $request->user()->id,
                ]);
            } catch (\Throwable $exception) {
                EmailLog::create([
                    'type' => 'role_assigned',
                    'to_email' => $user->email,
                    'to_user_id' => $user->id,
                    'subject' => 'Your account details were updated',
                    'status' => 'failed',
                    'error_message' => $exception->getMessage(),
                    'meta' => [
                        'role' => $user->role,
                        'class_room_id' => $user->class_room_id,
                        'action' => 'updated',
                    ],
                    'created_by' => $request->user()->id,
                ]);
            }
        }

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
