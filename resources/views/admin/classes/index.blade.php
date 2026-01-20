<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ __('Manage Classes') }}</h2>
            <a href="{{ route('admin.classes.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                {{ __('New Class') }}
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="w-full overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Name') }}</th>
                            <th class="px-6 py-4">{{ __('Code') }}</th>
                            <th class="px-6 py-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classRooms as $classRoom)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $classRoom->name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $classRoom->code }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.classes.edit', $classRoom) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('admin.classes.destroy', $classRoom) }}" onsubmit="return confirm('{{ __('Delete this class?') }}')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-500">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No classes yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
