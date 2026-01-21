<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Lecturer Dashboard') }}
        </h2>
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

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Published exams') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $publishedCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Live and visible to students.') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Draft exams') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $draftCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Still editable before publishing.') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Needs grading') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $needsGradingCount }}</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Submitted attempts with text answers.') }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Recent submissions') }}</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Latest student exam submissions.') }}</p>
                    </div>
                    <a href="{{ route('lecturer.exams.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        {{ __('Manage Exams') }}
                    </a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-[0.2em] text-slate-400">
                            <tr>
                                <th class="py-3 pr-4">{{ __('Student') }}</th>
                                <th class="py-3 pr-4">{{ __('Exam') }}</th>
                                <th class="py-3 pr-4">{{ __('Submitted') }}</th>
                                <th class="py-3 pr-4">{{ __('Status') }}</th>
                                <th class="py-3 pr-4">{{ __('Result') }}</th>
                                <th class="py-3 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAttempts as $attempt)
                                <tr class="border-t border-slate-100 dark:border-slate-800">
                                    <td class="py-3 pr-4 font-medium text-slate-900 dark:text-white">{{ $attempt->student?->name ?? __('-') }}</td>
                                    <td class="py-3 pr-4 text-slate-600 dark:text-slate-300">{{ $attempt->exam?->title ?? __('-') }}</td>
                                    <td class="py-3 pr-4 text-slate-600 dark:text-slate-300">{{ $attempt->submitted_at?->format('d M Y, H:i') ?? __('-') }}</td>
                                    <td class="py-3 pr-4">
                                        @php
                                            $statusLabel = __('Submitted');
                                            $statusClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300';
                                            if ($attempt->graded_at) {
                                                $statusLabel = __('Graded');
                                                $statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200';
                                            } elseif (($attempt->text_pending_count ?? 0) > 0) {
                                                $statusLabel = __('Ungraded');
                                                $statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200';
                                            }
                                        @endphp
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4 text-slate-600 dark:text-slate-300">
                                        @if ($attempt->graded_at)
                                            {{ __('Final') }}: {{ $attempt->final_score ?? 0 }} / {{ $attempt->final_total_points ?? 0 }}
                                        @elseif (($attempt->text_pending_count ?? 0) > 0)
                                            {{ __('Pending grading') }}
                                        @else
                                            {{ __('Auto') }}: {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        <a href="{{ route('lecturer.attempts.show', $attempt) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                            {{ __('Review') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                        {{ __('No submissions yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Create exams, add questions, and publish when you are ready.') }}
                </p>
                <a href="{{ route('lecturer.exams.index') }}" class="mt-4 inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    {{ __('Manage Exams') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
