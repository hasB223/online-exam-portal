<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ __('Pending Approval') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-base text-slate-700 dark:text-slate-300">
                    {{ __('Your registration has been received. An administrator will assign you to a class before you can access exams.') }}
                </p>
                <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300">
                    <p>{{ __('Account') }}: <span class="font-semibold">{{ $user->name }}</span></p>
                    <p>{{ __('Email') }}: <span class="font-semibold">{{ $user->email }}</span></p>
                </div>
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                    {{ __('If this takes too long, please contact your administrator for help.') }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
