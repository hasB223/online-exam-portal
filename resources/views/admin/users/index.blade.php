<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Name') }}</th>
                            <th class="px-6 py-4">{{ __('Email') }}</th>
                            <th class="px-6 py-4">{{ __('Role') }}</th>
                            <th class="px-6 py-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center gap-3">
                                        @csrf
                                        @method('patch')
                                        <select name="role" class="rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                                            @foreach (['admin', 'lecturer', 'student'] as $role)
                                                <option value="{{ $role }}" @selected($user->role === $role)>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="rounded-full bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-indigo-500">
                                            {{ __('Update') }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                    {{ __('Active') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
