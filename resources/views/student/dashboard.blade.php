<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => __('Dashboard'), 'url' => route('student.dashboard')],
            ]" />
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Student Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
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

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Next exams') }}</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Upcoming exams assigned to your class.') }}</p>
                    </div>
                    <a href="{{ route('student.exams.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        {{ __('View all') }}
                    </a>
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($exams as $exam)
                        @php
                            $attempt = $attempts->get($exam->id);
                            $status = $statuses[$exam->id] ?? 'not_started';
                        @endphp
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="font-semibold text-slate-900 dark:text-white">{{ $exam->title }}</h4>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $status === 'submitted' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200' : '' }}
                                    {{ $status === 'in_progress' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200' : '' }}
                                    {{ $status === 'expired' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900 dark:text-rose-200' : '' }}
                                    {{ $status === 'not_started' ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' : '' }}
                                ">
                                    {{ $status === 'submitted' ? __('ui.status.submitted') : '' }}
                                    {{ $status === 'in_progress' ? __('ui.status.in_progress') : '' }}
                                    {{ $status === 'expired' ? __('ui.status.expired') : '' }}
                                    {{ $status === 'not_started' ? __('ui.status.not_started') : '' }}
                                </span>
                            </div>
                            <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                                <div>{{ __('Subject') }}: {{ $exam->subject?->name ?? __('-') }}</div>
                                <div>{{ __('Duration') }}: {{ $exam->duration_minutes ? $exam->duration_minutes.' '.__('minutes') : __('No limit') }}</div>
                            </div>
                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                @if (! $attempt)
                                    <a href="{{ route('student.exams.show', $exam) }}" class="rounded-full bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-indigo-500">
                                        {{ __('Start') }}
                                    </a>
                                @elseif ($status === 'in_progress')
                                    <a href="{{ route('student.attempts.show', $attempt) }}" class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                        {{ __('Resume') }}
                                    </a>
                                @elseif ($status === 'expired')
                                    <span class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-400 dark:border-slate-700 dark:text-slate-500">
                                        {{ __('Expired') }}
                                    </span>
                                @else
                                    <a href="{{ route('student.attempts.show', $attempt) }}" class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                        {{ __('View') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 sm:col-span-2 lg:col-span-3">
                            {{ __('No exams are available right now.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Recent activity') }}</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Your latest submitted exams and scores.') }}</p>
                    </div>
                    <a href="{{ route('student.exams.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        {{ __('View all') }}
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recentAttempts as $attempt)
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-300">
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $attempt->exam?->title ?? __('-') }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">{{ $attempt->submitted_at?->format('d M Y, H:i') ?? __('-') }}</div>
                            </div>
                            <div class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                @if ($attempt->graded_at)
                                    {{ __('Final') }}: {{ $attempt->final_score ?? 0 }} / {{ $attempt->final_total_points ?? 0 }}
                                @else
                                    {{ __('Auto') }}: {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}
                                @endif
                            </div>
                            <a href="{{ route('student.attempts.show', $attempt) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                {{ __('View') }}
                            </a>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-6 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400">
                            {{ __('No recent submissions yet.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Browse available exams and track your attempts.') }}
                </p>
                <a href="{{ route('student.exams.index') }}" class="mt-4 inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    {{ __('View Exams') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
