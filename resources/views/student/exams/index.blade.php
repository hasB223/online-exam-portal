<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => __('Dashboard'), 'url' => route('student.dashboard')],
                ['label' => __('Exams'), 'url' => route('student.exams.index')],
            ]" />
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Available Exams') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                @forelse ($exams as $exam)
                    @php
                        $attempt = $attempts->get($exam->id);
                        $status = $statuses[$exam->id] ?? 'not_started';
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $exam->title }}</h3>
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
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $exam->description ?? __('No description yet.') }}</p>
                        <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                            <span>{{ __('Questions') }}: {{ $exam->questions_count }}</span>
                            <span>•</span>
                            <span>{{ __('Duration') }}: {{ $exam->duration_minutes ? $exam->duration_minutes.' '.__('minutes') : __('No limit') }}</span>
                        </div>
                        <div class="mt-5 flex flex-wrap items-center gap-3">
                            <a href="{{ route('student.exams.show', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                {{ __('View Details') }}
                            </a>
                            @if ($attempt)
                                <a href="{{ route('student.attempts.show', $attempt) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                    {{ __('Show Attempt') }}
                                </a>
                            @endif
                        </div>
                        @if ($attempt?->isSubmitted())
                            <div class="mt-4 flex flex-wrap gap-2 text-xs">
                                @if ($attempt->isGraded())
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                                        {{ __('Final score') }} {{ $attempt->final_score ?? 0 }} / {{ $attempt->final_total_points ?? 0 }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                                        {{ __('Auto score') }} {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}
                                    </span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ __('Text answers recorded') }}: {{ $attempt->text_pending_count ?? 0 }}
                                    </span>
                                    <span class="rounded-full bg-amber-100 px-3 py-1 font-semibold text-amber-700 dark:bg-amber-900 dark:text-amber-200">
                                        {{ __('Pending grading') }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400">
                        {{ __('No exams are available at the moment.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
