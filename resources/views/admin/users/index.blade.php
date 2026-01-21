@extends('layouts.admin')

@section('header')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <span>{{ __('Manage Users') }}</span>
        <a href="{{ route('admin.users.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
            {{ __('New User') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.users.index') }}" class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:grid-cols-[1fr,1fr,auto,auto]">
                <div>
                    <x-input-label for="role_filter" :value="__('Role')" />
                    <select id="role_filter" name="role" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                        <option value="all" @selected(($role ?? 'all') === 'all')>{{ __('All') }}</option>
                        <option value="admin" @selected(($role ?? 'all') === 'admin')>{{ __('Admin') }}</option>
                        <option value="lecturer" @selected(($role ?? 'all') === 'lecturer')>{{ __('Lecturer') }}</option>
                        <option value="student" @selected(($role ?? 'all') === 'student')>{{ __('Student') }}</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="status_filter" :value="__('Status')" />
                    <select id="status_filter" name="status" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                        <option value="all" @selected(($status ?? 'all') === 'all')>{{ __('All') }}</option>
                        <option value="active" @selected(($status ?? 'all') === 'active')>{{ __('Active') }}</option>
                        <option value="pending" @selected(($status ?? 'all') === 'pending')>{{ __('Pending') }}</option>
                    </select>
                </div>
                <label class="mt-6 inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                    <input type="checkbox" name="unassigned" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700" @checked($unassigned ?? false) />
                    <span>{{ __('Unassigned students only') }}</span>
                </label>
                <div class="mt-6 flex items-center gap-2">
                    <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-500">
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Clear') }}
                    </a>
                </div>
            </form>

            <div class="w-full overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Name') }}</th>
                            <th class="px-6 py-4">{{ __('Email') }}</th>
                            <th class="px-6 py-4">{{ __('Role') }}</th>
                            <th class="px-6 py-4">{{ __('Status') }}</th>
                            <th class="px-6 py-4">{{ __('Class') }}</th>
                            <th class="px-6 py-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ ucfirst($user->role) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200' : '' }}
                                        {{ $user->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200' : '' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $user->classRoom?->name ?? __('-') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ __('Delete this user?') }}')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-500">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No users yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
