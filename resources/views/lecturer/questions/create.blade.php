<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Add Question') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="POST" action="{{ route('lecturer.questions.store', $exam) }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="prompt" :value="__('Question')" />
                        <textarea id="prompt" name="prompt" rows="4" class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">{{ old('prompt') }}</textarea>
                        <x-input-error :messages="$errors->get('prompt')" class="mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @for ($i = 0; $i < 4; $i++)
                            <div>
                                <x-input-label for="option_{{ $i }}" :value="__('Option').' '.($i + 1)" />
                                <x-text-input id="option_{{ $i }}" name="options[{{ $i }}]" class="mt-1 block w-full" :value="old('options.'.$i)" required />
                            </div>
                        @endfor
                        <x-input-error :messages="$errors->get('options')" class="sm:col-span-2 mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="correct_option" :value="__('Correct Option')" />
                            <select id="correct_option" name="correct_option" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                                @for ($i = 0; $i < 4; $i++)
                                    <option value="{{ $i }}" @selected(old('correct_option') == $i)>{{ __('Option') }} {{ $i + 1 }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('correct_option')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="points" :value="__('Points')" />
                            <x-text-input id="points" name="points" type="number" min="1" class="mt-1 block w-full" :value="old('points', 1)" required />
                            <x-input-error :messages="$errors->get('points')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('lecturer.exams.edit', $exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            {{ __('Back') }}
                        </a>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Save Question') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
