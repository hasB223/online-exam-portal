<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

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
