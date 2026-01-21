<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => __('Dashboard'), 'url' => route('lecturer.dashboard')],
                ['label' => __('Manage Exams'), 'url' => route('lecturer.exams.index')],
                ['label' => __('Attempts'), 'url' => null],
            ]" />
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                    {{ __('Attempts for') }} {{ $exam->title }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                <div>
                    {{ __('Class') }}: {{ $exam->classRoom?->name ?? __('-') }}
                    <span class="mx-2 text-slate-300">—</span>
                    {{ __('Students') }}: {{ $students->count() }}
                    <span class="mx-2 text-slate-300">—</span>
                    {{ __('Attempts submitted') }}: {{ $submittedCount }}
                </div>
                <a href="{{ route('lecturer.exams.attempts.export', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                    {{ __('Export CSV') }}
                </a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="min-w-[1100px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Student') }}</th>
                            <th class="px-6 py-4">{{ __('Email') }}</th>
                            <th class="px-6 py-4">{{ __('Status') }}</th>
                            <th class="px-6 py-4">{{ __('Result') }}</th>
                            <th class="px-6 py-4">{{ __('Submitted') }}</th>
                            <th class="px-6 py-4">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $attempt = $attemptsByStudent->get($student->id);
                                $statusLabel = __('Not started');
                                $statusClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300';

                                if ($attempt) {
                                    if ($attempt->graded_at) {
                                        $statusLabel = __('Graded');
                                        $statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200';
                                    } elseif ($attempt->status === 'expired') {
                                        $statusLabel = __('Expired');
                                        $statusClass = 'bg-rose-100 text-rose-700 dark:bg-rose-900 dark:text-rose-200';
                                    } elseif ($attempt->status === 'in_progress') {
                                        $statusLabel = __('In progress');
                                        $statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200';
                                    } elseif ($attempt->status === 'submitted' && ($attempt->text_pending_count ?? 0) > 0) {
                                        $statusLabel = __('Ungraded');
                                        $statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200';
                                    } elseif ($attempt->status === 'submitted') {
                                        $statusLabel = __('Submitted');
                                        $statusClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300';
                                    }
                                }
                            @endphp
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $student->name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $student->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    @if ($attempt && $attempt->graded_at)
                                        {{ __('Final') }}: {{ $attempt->final_score ?? 0 }} / {{ $attempt->final_total_points ?? 0 }}
                                    @elseif ($attempt)
                                        {{ __('Auto') }}: {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}
                                        @if (($attempt->text_pending_count ?? 0) > 0 && ! $attempt->graded_at)
                                            <div class="mt-1 text-xs text-slate-400">{{ __('Text pending') }}: {{ $attempt->text_pending_count }}</div>
                                        @endif
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt?->submitted_at?->format('d M Y, H:i') ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if ($attempt)
                                        <a href="{{ route('lecturer.attempts.show', $attempt) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                            {{ __('Review') }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No students found for this class.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
