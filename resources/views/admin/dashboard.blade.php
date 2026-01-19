<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Manage roles, accounts, and platform settings from here.') }}
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        {{ __('Manage Users') }}
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Manage Classes') }}
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Manage Subjects') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
