<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Available Exams') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                @forelse ($exams as $exam)
                    @php
                        $attempt = $attempts->get($exam->id);
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $exam->title }}</h3>
                            @if ($attempt?->isSubmitted())
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                                    {{ __('Completed') }}
                                </span>
                            @endif
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
                            @if ($attempt?->isSubmitted())
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('Score') }}: {{ $attempt->score }} / {{ $attempt->total_points }}
                                </span>
                            @endif
                        </div>
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
