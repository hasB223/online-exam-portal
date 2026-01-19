<nav class="border-b border-slate-200 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-950/80">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-lg font-semibold text-slate-900 dark:text-slate-100">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-600 text-white">OP</span>
                <span>{{ __('Online Exam') }}</span>
            </a>

            <div class="hidden items-center gap-6 md:flex">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                    {{ __('Dashboard') }}
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                        {{ __('Users') }}
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                        {{ __('Classes') }}
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                        {{ __('Subjects') }}
                    </a>
                @endif
                @if(auth()->user()->isLecturer() || auth()->user()->isAdmin())
                    <a href="{{ route('lecturer.exams.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                        {{ __('Manage Exams') }}
                    </a>
                @endif
                @if(auth()->user()->isStudent())
                    <a href="{{ route('student.exams.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                        {{ __('My Exams') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-indigo-600' : '' }}">{{ __('EN') }}</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('locale.switch', 'ms') }}" class="{{ app()->getLocale() === 'ms' ? 'text-indigo-600' : '' }}">{{ __('MS') }}</a>
            </div>

            <button type="button" data-theme-toggle class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                <span class="sr-only">{{ __('Toggle theme') }}</span>
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
                        {{ __('Profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-800 dark:text-slate-200 md:hidden" data-mobile-nav-toggle>
            <span class="sr-only">{{ __('Open menu') }}</span>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div class="hidden border-t border-slate-200 bg-white px-4 py-4 dark:border-slate-800 dark:bg-slate-950 md:hidden" data-mobile-nav>
        <div class="space-y-3">
            <a href="{{ route('dashboard') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                {{ __('Dashboard') }}
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                    {{ __('Users') }}
                </a>
                <a href="{{ route('admin.classes.index') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                    {{ __('Classes') }}
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                    {{ __('Subjects') }}
                </a>
            @endif
            @if(auth()->user()->isLecturer() || auth()->user()->isAdmin())
                <a href="{{ route('lecturer.exams.index') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                    {{ __('Manage Exams') }}
                </a>
            @endif
            @if(auth()->user()->isStudent())
                <a href="{{ route('student.exams.index') }}" class="block text-sm font-medium text-slate-600 dark:text-slate-300">
                    {{ __('My Exams') }}
                </a>
            @endif
        </div>

        <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-4 dark:border-slate-800">
            <div class="text-sm text-slate-600 dark:text-slate-300">
                {{ Auth::user()->name }}
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-semibold {{ app()->getLocale() === 'en' ? 'text-indigo-600' : 'text-slate-500 dark:text-slate-400' }}">
                    {{ __('EN') }}
                </a>
                <a href="{{ route('locale.switch', 'ms') }}" class="text-xs font-semibold {{ app()->getLocale() === 'ms' ? 'text-indigo-600' : 'text-slate-500 dark:text-slate-400' }}">
                    {{ __('MS') }}
                </a>
                <button type="button" data-theme-toggle class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-600 dark:border-slate-800 dark:text-slate-300">
                    <span class="sr-only">{{ __('Toggle theme') }}</span>
                    <svg data-theme-icon="light" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                    </svg>
                    <svg data-theme-icon="dark" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" />
                    </svg>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-slate-600 dark:text-slate-300">{{ __('Log Out') }}</button>
                </form>
            </div>
        </div>
    </div>
</nav>
