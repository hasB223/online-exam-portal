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
        <div class="min-h-screen bg-slate-950 text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.35),_transparent_55%)]"></div>
            <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-6">
                <header class="flex items-center justify-between py-8">
                    <div class="flex items-center gap-3 text-lg font-semibold">
                        <span class="grid h-10 w-10 place-items-center rounded-2xl bg-indigo-500">OP</span>
                        <span>{{ __('Online Exam') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-semibold uppercase tracking-[0.2em] {{ app()->getLocale() === 'en' ? 'text-indigo-300' : 'text-slate-400' }}">{{ __('EN') }}</a>
                        <a href="{{ route('locale.switch', 'ms') }}" class="text-xs font-semibold uppercase tracking-[0.2em] {{ app()->getLocale() === 'ms' ? 'text-indigo-300' : 'text-slate-400' }}">{{ __('MS') }}</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
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
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-indigo-300">{{ __('Smart Evaluation') }}</p>
                            <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">
                                {{ __('Assess faster, teach smarter.') }}
                            </h1>
                            <p class="mt-6 text-lg text-slate-300">
                                {{ __('Deliver secure online exams, build question banks, and analyze results with a clean workflow for administrators, lecturers, and students.') }}
                            </p>
                            <div class="mt-8 flex flex-wrap gap-4">
                                <a href="{{ route('login') }}" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-indigo-100">
                                    {{ __('Get Started') }}
                                </a>
                                <button type="button" data-theme-toggle class="rounded-full border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                    {{ __('Toggle Theme') }}
                                </button>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">{{ __('Admin') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Control access') }}</h3>
                                <p class="mt-2 text-sm text-slate-300">{{ __('Assign roles, manage users, and oversee exam publishing.') }}</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">{{ __('Lecturer') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Craft assessments') }}</h3>
                                <p class="mt-2 text-sm text-slate-300">{{ __('Build exams, add questions, and track submissions.') }}</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-6 backdrop-blur sm:col-span-2">
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">{{ __('Student') }}</p>
                                <h3 class="mt-4 text-xl font-semibold">{{ __('Stay focused') }}</h3>
                                <p class="mt-2 text-sm text-slate-300">{{ __('Join exams on time, submit answers, and see results instantly.') }}</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
