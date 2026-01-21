<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Online Exam Portal') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            (function () {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored || (prefersDark ? 'dark' : 'light');
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased text-slate-900 dark:text-slate-100">
        <div class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.18),_transparent_55%)] dark:bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.35),_transparent_55%)]"></div>
            <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-6">
                <header class="flex items-center justify-between py-8">
                    <div class="flex items-center gap-3 text-lg font-semibold">
                        <span class="grid h-10 w-10 place-items-center rounded-2xl bg-indigo-500 text-white">OP</span>
                        <span>{{ __('Online Exam') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-semibold uppercase tracking-[0.2em] {{ app()->getLocale() === 'en' ? 'text-indigo-600' : 'text-slate-500 dark:text-slate-400' }}">{{ __('EN') }}</a>
                        <a href="{{ route('locale.switch', 'ms') }}" class="text-xs font-semibold uppercase tracking-[0.2em] {{ app()->getLocale() === 'ms' ? 'text-indigo-600' : 'text-slate-500 dark:text-slate-400' }}">{{ __('MS') }}</a>
                        <button type="button" data-theme-toggle class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            <span class="sr-only">{{ __('Toggle Theme') }}</span>
                            <svg data-theme-icon="light" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                            </svg>
                            <svg data-theme-icon="dark" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" />
                            </svg>
                        </button>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                    {{ __('Log In') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full bg-indigo-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-400">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </header>

                <main class="flex flex-1 flex-col justify-center pb-16">
                    <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-indigo-500">{{ __('Smart Evaluation') }}</p>
                            <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">
                                {{ __('Assess faster, teach smarter.') }}
                            </h1>
                            <p class="mt-6 text-lg text-slate-600 dark:text-slate-300">
                                {{ __('Deliver secure online exams, build question banks, and analyze results with a clean workflow for administrators, lecturers, and students.') }}
                            </p>
                            <div class="mt-8 space-y-2">
                                <div class="flex flex-wrap items-center gap-4">
                                    <a href="{{ route('login') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-indigo-100">
                                    {{ __('Get Started') }}
                                </a>
                                @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-full bg-indigo-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400">
                                            {{ __('Register') }}
                                        </a>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200/60 bg-white/70 p-6 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/10">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Admin') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Control access') }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ __('Assign roles, manage users, and oversee exam publishing.') }}</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200/60 bg-white/70 p-6 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/10">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Lecturer') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Craft assessments') }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ __('Build exams, add questions, and track submissions.') }}</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200/60 bg-white/70 p-6 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/10 sm:col-span-2">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Student') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Stay focused') }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ __('Join exams on time, submit answers, and see results instantly.') }}</p>
                            </div>
                        </div>
                    </div>

                    <section class="mt-16 grid gap-8 lg:grid-cols-[1.2fr,1fr]">
                        <div>
                            <h2 class="text-2xl font-semibold">{{ __('How it works') }}</h2>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ __('A simple, role-based flow from setup to results.') }}</p>
                            <div class="mt-6 grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                                <div class="rounded-2xl border border-slate-200/60 bg-white/70 p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Admin') }}</p>
                                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-200">{{ __('Set up classes & subjects, manage users.') }}</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200/60 bg-white/70 p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Lecturer') }}</p>
                                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-200">{{ __('Create and publish exams, grade text answers.') }}</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200/60 bg-white/70 p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 dark:text-indigo-200">{{ __('Student') }}</p>
                                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-200">{{ __('Take timed exams and view results.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-slate-200/60 bg-white/70 p-6 shadow-sm dark:border-white/10 dark:bg-white/5">
                            <h3 class="text-lg font-semibold">{{ __('Key features') }}</h3>
                            <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                                <li>{{ __('Timed exams with automatic expiry') }}</li>
                                <li>{{ __('Class-based access control') }}</li>
                                <li>{{ __('MCQ auto-scoring') }}</li>
                                <li>{{ __('Text answer grading workflow') }}</li>
                                <li>{{ __('Role-based announcements') }}</li>
                                <li>{{ __('CSV export for results') }}</li>
                            </ul>
                        </div>
                    </section>

                    @if (app()->environment('local'))
                        <section class="mt-12">
                            <details class="rounded-2xl border border-slate-200/60 bg-white/70 p-6 shadow-sm dark:border-white/10 dark:bg-white/5">
                                <summary class="cursor-pointer text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    {{ __('Demo accounts') }}
                                </summary>
                                <div class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                                    <p><span class="text-slate-400 dark:text-slate-500">{{ __('Admin') }}:</span> admin@example.com</p>
                                    <p><span class="text-slate-400 dark:text-slate-500">{{ __('Lecturer') }}:</span> lecturer@example.com</p>
                                    <p><span class="text-slate-400 dark:text-slate-500">{{ __('Student') }}:</span> student1@example.com</p>
                                    <p><span class="text-slate-400 dark:text-slate-500">{{ __('Student') }}:</span> student2@example.com</p>
                                    <p><span class="text-slate-400 dark:text-slate-500">{{ __('Password') }}:</span> password</p>
                                </div>
                            </details>
                        </section>
                    @endif
                </main>

                <footer class="border-t border-slate-200/60 py-8 text-center text-xs text-slate-500 dark:border-white/10 dark:text-slate-400">
                    {{ config('app.name', 'Online Exam Portal') }} © {{ now()->year }}
                </footer>
            </div>
        </div>
    </body>
</html>
