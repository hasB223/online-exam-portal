@extends('layouts.admin')

@section('header')
    <div class="space-y-2">
        <x-breadcrumbs :items="[
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Email Logs'), 'url' => route('admin.email-logs.index')],
        ]" />
        <span>{{ __('Email Logs') }}</span>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="GET" action="{{ route('admin.email-logs.index') }}" class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                            @foreach (['all', 'queued', 'sent', 'failed'] as $option)
                                <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <x-text-input id="type" name="type" class="mt-1 block w-full" :value="$type" placeholder="{{ __('Search type') }}" />
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Filter') }}
                        </button>
                        <a href="{{ route('admin.email-logs.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4">{{ __('Sent At') }}</th>
                            <th class="px-6 py-4">{{ __('Type') }}</th>
                            <th class="px-6 py-4">{{ __('Recipient') }}</th>
                            <th class="px-6 py-4">{{ __('Status') }}</th>
                            <th class="px-6 py-4">{{ __('Subject') }}</th>
                            <th class="px-6 py-4">{{ __('Error') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="border-t border-slate-100 dark:border-slate-800">
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ ($log->sent_at ?? $log->created_at)?->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $log->type }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    <div>{{ $log->to_email }}</div>
                                    @if ($log->recipient)
                                        <div class="text-xs text-slate-400">{{ $log->recipient->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $log->status === 'sent' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200' : '' }}
                                        {{ $log->status === 'queued' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200' : '' }}
                                        {{ $log->status === 'failed' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900 dark:text-rose-200' : '' }}
                                    ">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $log->subject ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                    @if ($log->status === 'failed' && $log->error_message)
                                        {{ \Illuminate\Support\Str::limit($log->error_message, 80) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('No email logs yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
