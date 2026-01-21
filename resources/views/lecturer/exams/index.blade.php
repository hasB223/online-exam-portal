<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => __('Dashboard'), 'url' => route('lecturer.dashboard')],
                ['label' => __('Manage Exams'), 'url' => route('lecturer.exams.index')],
            ]" />
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Manage Exams') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Create, schedule, and publish exams for your classes.') }}
                </p>
                <a href="{{ route('lecturer.exams.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    {{ __('New Exam') }}
                </a>
            </div>

            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                @forelse ($exams as $exam)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $exam->title }}</h3>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $exam->is_published ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200' : 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200' }}">
                                {{ $exam->is_published ? __('Published') : __('Draft') }}
                            </span>
                        </div>
                        <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            <div>{{ __('Class') }}: {{ $exam->classRoom?->name ?? __('-') }}</div>
                            <div>{{ __('Subject') }}: {{ $exam->subject?->name ?? __('-') }}</div>
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                            <span>{{ __('Questions') }}: {{ $exam->questions_count }}</span>
                            <span>•</span>
                            <span>{{ __('Duration') }}: {{ $exam->duration_minutes ? $exam->duration_minutes.' '.__('minutes') : __('No limit') }}</span>
                        </div>
                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('lecturer.exams.edit', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('lecturer.exams.clone', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                {{ __('Clone') }}
                            </a>
                            <a href="{{ route('lecturer.exams.attempts.index', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                {{ __('View Attempts') }}
                            </a>
                            <form method="POST" action="{{ route('lecturer.exams.destroy', $exam) }}" onsubmit="return confirm('{{ __('Delete this exam?') }}')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="rounded-full border border-red-200 px-4 py-2 text-xs font-semibold text-red-600 transition hover:border-red-400 hover:text-red-700 dark:border-red-800 dark:text-red-300">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400">
                        {{ __('No exams yet. Create your first exam to get started.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
