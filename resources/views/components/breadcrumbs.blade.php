@props(['items' => []])

@if (! empty($items))
    <nav aria-label="{{ __('Breadcrumb') }}" class="text-xs text-slate-500 dark:text-slate-400">
        <ol class="flex flex-wrap items-center gap-2">
            @foreach ($items as $item)
                <li class="flex items-center gap-2">
                    @if (! $loop->first)
                        <span class="text-slate-300 dark:text-slate-600">/</span>
                    @endif
                    @if ($loop->last || empty($item['url']))
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $item['label'] }}</span>
                    @else
                        <a href="{{ $item['url'] }}" class="transition hover:text-slate-900 dark:hover:text-white">
                            {{ $item['label'] }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
