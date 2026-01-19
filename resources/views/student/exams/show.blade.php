<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $exam->description ?? __('No description yet.') }}</p>

                <div class="mt-4 grid gap-4 text-sm text-slate-600 dark:text-slate-400 sm:grid-cols-2">
                    <div>{{ __('Questions') }}: {{ $exam->questions_count }}</div>
                    <div>{{ __('Duration') }}: {{ $exam->duration_minutes ? $exam->duration_minutes.' '.__('minutes') : __('No limit') }}</div>
                    <div>{{ __('Starts') }}: {{ $exam->starts_at?->format('d M Y, H:i') ?? __('Anytime') }}</div>
                    <div>{{ __('Ends') }}: {{ $exam->ends_at?->format('d M Y, H:i') ?? __('No limit') }}</div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    @if ($attempt?->isSubmitted())
                        <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                            {{ __('Submitted') }}
                        </span>
                    @elseif ($attempt?->isExpired())
                        <span class="rounded-full bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 dark:bg-rose-900 dark:text-rose-200">
                            {{ __('Expired') }}
                        </span>
                    @else
                        <form method="POST" action="{{ route('student.exams.start', $exam) }}">
                            @csrf
                            <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                {{ $attempt ? __('Resume Exam') : __('Start Exam') }}
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('student.exams.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
