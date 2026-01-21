@extends('layouts.admin')

@section('header')
    {{ __('Admin Dashboard') }}
@endsection

@section('content')
    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if ($announcements->isNotEmpty())
                <div class="space-y-3">
                    @foreach ($announcements as $announcement)
                        <div class="rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-indigo-900 dark:border-indigo-700 dark:bg-indigo-950 dark:text-indigo-100">
                            <p class="font-semibold">{{ $announcement->title }}</p>
                            <p class="mt-1 text-indigo-800/80 dark:text-indigo-100/80">{{ $announcement->body }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('admin.users.index', ['role' => 'student', 'status' => 'pending']) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-500 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Pending students') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $pendingStudentsCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Awaiting approval') }}</p>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'student', 'unassigned' => 1]) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-500 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Unassigned students') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $unassignedStudentsCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('No class assigned') }}</p>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'student', 'status' => 'active']) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-500 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Active students') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $activeStudentsCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Assigned and active') }}</p>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'lecturer']) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-500 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Lecturers') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $lecturersCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Teaching staff') }}</p>
                </a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Manage roles, accounts, and platform settings from here.') }}
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        {{ __('Manage Users') }}
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Manage Classes') }}
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Manage Subjects') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
