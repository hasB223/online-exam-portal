@extends('layouts.admin')

@section('header')
    <div class="space-y-2">
        <x-breadcrumbs :items="[
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Announcements'), 'url' => route('admin.announcements.index')],
        ]" />
        <div class="flex flex-wrap items-center justify-between gap-3">
            <span>{{ __('Announcements') }}</span>
            <a href="{{ route('admin.announcements.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                {{ __('New Announcement') }}
            </a>
        </div>
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

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Title') }}</th>
                            <th class="px-6 py-4">{{ __('Audience') }}</th>
                            <th class="px-6 py-4">{{ __('Active') }}</th>
                            <th class="px-6 py-4">{{ __('Starts') }}</th>
                            <th class="px-6 py-4">{{ __('Ends') }}</th>
                            <th class="px-6 py-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $announcement->title }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ ucfirst($announcement->audience) }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $announcement->is_active ? __('Yes') : __('No') }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $announcement->starts_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $announcement->ends_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                        {{ __('Edit') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No announcements yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
