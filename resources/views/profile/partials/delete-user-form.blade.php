<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <details class="rounded-2xl border border-red-200 bg-red-50/60 p-4 dark:border-red-800 dark:bg-red-950/40">
        <summary class="cursor-pointer text-sm font-semibold text-red-700 dark:text-red-300">
            {{ __('Delete Account') }}
        </summary>

        <form method="post" action="{{ route('profile.destroy') }}" class="mt-4 space-y-4">
            @csrf
            @method('delete')

            <p class="text-sm text-red-700/80 dark:text-red-200">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <x-danger-button>
                {{ __('Delete Account') }}
            </x-danger-button>
        </form>
    </details>
</section>
