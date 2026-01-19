@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:border-slate-700 dark:bg-slate-950']) }}>
