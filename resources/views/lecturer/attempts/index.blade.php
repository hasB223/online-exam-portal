<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Attempts for') }} {{ $exam->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="min-w-[900px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Student') }}</th>
                            <th class="px-6 py-4">{{ __('Status') }}</th>
                            <th class="px-6 py-4">{{ __('Started') }}</th>
                            <th class="px-6 py-4">{{ __('Submitted') }}</th>
                            <th class="px-6 py-4">{{ __('Ends') }}</th>
                            <th class="px-6 py-4">{{ __('Auto score') }}</th>
                            <th class="px-6 py-4">{{ __('Text pending') }}</th>
                            <th class="px-6 py-4">{{ __('Final score') }}</th>
                            <th class="px-6 py-4">{{ __('Graded') }}</th>
                            <th class="px-6 py-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attempts as $attempt)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $attempt->student?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ ucfirst($attempt->status) }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->started_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->submitted_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->ends_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->text_pending_count ?? 0 }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->final_score ?? '-' }} / {{ $attempt->final_total_points ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $attempt->graded_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('lecturer.attempts.show', $attempt) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                        {{ __('View') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No attempts yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
