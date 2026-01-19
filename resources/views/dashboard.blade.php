<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm uppercase tracking-[0.2em] text-indigo-500">{{ __('Portal') }}</p>
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Welcome') }}</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Role') }}: {{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-indigo-500 via-indigo-600 to-slate-900 p-6 text-white shadow-lg">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-200">{{ __('Focus') }}</p>
                    <h3 class="mt-3 text-xl font-semibold">{{ __('Next Action') }}</h3>
                    <p class="mt-2 text-sm text-indigo-100">
                        {{ __('Use the shortcuts below to jump into your main workspace.') }}
                    </p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('Status') }}</p>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                        {{ __('All systems ready. Remember to publish exams when you are ready for students to start.') }}
                    </p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                @if(auth()->user()->isAdmin())
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Admin Controls') }}</h4>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Manage accounts and assign roles.') }}</p>
                        <a href="{{ route('admin.users.index') }}" class="mt-4 inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Manage Users') }}
                        </a>
                    </div>
                @endif
                @if(auth()->user()->isLecturer() || auth()->user()->isAdmin())
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Lecturer Workspace') }}</h4>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Create exams, add questions, and publish when ready.') }}</p>
                        <a href="{{ route('lecturer.exams.index') }}" class="mt-4 inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Manage Exams') }}
                        </a>
                    </div>
                @endif
                @if(auth()->user()->isStudent())
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Student Zone') }}</h4>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Browse available exams and track your attempts.') }}</p>
                        <a href="{{ route('student.exams.index') }}" class="mt-4 inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('View Exams') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
