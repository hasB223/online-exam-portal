<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-full font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:border-indigo-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200']) }}>
    {{ $slot }}
</button>
