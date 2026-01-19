@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div data-modal="{{ $name }}" class="{{ $show ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    <div class="fixed inset-0 bg-gray-500/75"></div>

    <div class="relative mb-6 mx-auto w-full {{ $maxWidth }} rounded-lg bg-white shadow-xl dark:bg-slate-900">
        {{ $slot }}
    </div>
</div>
