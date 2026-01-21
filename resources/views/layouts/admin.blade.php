<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Online Exam Portal') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 dark:text-slate-100">
        @php
            $navItemClass = fn (bool $active) => $active
                ? 'flex items-center gap-3 rounded-xl bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm'
                : 'flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white';
        @endphp

        <div class="min-h-screen bg-slate-100 dark:bg-slate-950">
            <div class="flex min-h-screen">
                <div class="fixed inset-0 z-20 hidden bg-slate-900/50 md:hidden" data-admin-sidebar-backdrop></div>
                <aside data-admin-sidebar class="fixed inset-y-0 left-0 z-30 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white px-4 py-6 shadow-xl transition-transform duration-200 dark:border-slate-800 dark:bg-slate-950 md:static md:w-64 md:translate-x-0 md:shadow-none">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-lg font-semibold text-slate-900 dark:text-white">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-600 text-white">OP</span>
                            <span>{{ __('Admin') }}</span>
                        </a>
                        <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 dark:border-slate-800 dark:text-slate-300 md:hidden" data-admin-sidebar-toggle aria-expanded="false">
                            <span class="sr-only">{{ __('Close menu') }}</span>
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">{{ __('Admin') }}</p>
                            <div class="mt-3 space-y-2">
                                <a href="{{ route('admin.dashboard') }}" class="{{ $navItemClass(request()->routeIs('admin.dashboard')) }}">
                                    {{ __('Dashboard') }}
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="{{ $navItemClass(request()->routeIs('admin.users.*')) }}">
                                    {{ __('Users') }}
                                </a>
                                <a href="{{ route('admin.classes.index') }}" class="{{ $navItemClass(request()->routeIs('admin.classes.*')) }}">
                                    {{ __('Classes') }}
                                </a>
                                <a href="{{ route('admin.subjects.index') }}" class="{{ $navItemClass(request()->routeIs('admin.subjects.*')) }}">
                                    {{ __('Subjects') }}
                                </a>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">{{ __('Communication') }}</p>
                            <div class="mt-3 space-y-2">
                                <a href="{{ route('admin.announcements.index') }}" class="{{ $navItemClass(request()->routeIs('admin.announcements.*')) }}">
                                    {{ __('Announcements') }}
                                </a>
                                <a href="{{ route('admin.email-logs.index') }}" class="{{ $navItemClass(request()->routeIs('admin.email-logs.*')) }}">
                                    {{ __('Email Logs') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-950/80">
                        <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-6 lg:px-8">
                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-800 dark:text-slate-200 md:hidden" data-admin-sidebar-toggle aria-expanded="false">
                                    <span class="sr-only">{{ __('Open menu') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <div class="text-2xl font-semibold text-slate-900 dark:text-white">
                                    @yield('header')
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                                    <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-indigo-600' : '' }}">{{ __('EN') }}</a>
                                    <span class="text-slate-300">/</span>
                                    <a href="{{ route('locale.switch', 'ms') }}" class="{{ app()->getLocale() === 'ms' ? 'text-indigo-600' : '' }}">{{ __('MS') }}</a>
                                </div>

                                <button type="button" data-theme-toggle class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                    <span class="sr-only">{{ __('ui.nav.toggle_theme') }}</span>
                                    <svg data-theme-icon="light" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                                    </svg>
                                    <svg data-theme-icon="dark" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" />
                                    </svg>
                                </button>

                                <div class="relative" data-dropdown>
                                    <button type="button" data-dropdown-trigger class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:border-indigo-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200">
                                        <span>{{ Auth::user()->name }}</span>
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div data-dropdown-menu class="absolute right-0 z-20 mt-2 hidden w-48 rounded-2xl border border-slate-200 bg-white p-2 text-sm shadow-xl dark:border-slate-800 dark:bg-slate-950">
                                        <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white">
                                            {{ __('ui.nav.profile') }}
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white">
                                                {{ __('ui.nav.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
