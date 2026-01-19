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

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950" data-question-type>
                                <option value="mcq" @selected(old('type') === 'mcq')>{{ __('Multiple Choice') }}</option>
                                <option value="text" @selected(old('type') === 'text')>{{ __('Text') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="points" :value="__('Points')" />
                            <x-text-input id="points" name="points" type="number" min="1" class="mt-1 block w-full" :value="old('points', 1)" required />
                            <x-input-error :messages="$errors->get('points')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="question_text" :value="__('Question')" />
                        <textarea id="question_text" name="question_text" rows="4" class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">{{ old('question_text') }}</textarea>
                        <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                    </div>

                    <div data-choice-fields>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Choices') }}</p>
                        <div class="mt-2 grid gap-4 sm:grid-cols-2">
                            @for ($i = 0; $i < 6; $i++)
                                <div>
                                    <x-input-label for="choice_{{ $i }}" :value="__('Choice').' '.($i + 1)" />
                                    <x-text-input id="choice_{{ $i }}" name="choices[{{ $i }}]" class="mt-1 block w-full" :value="old('choices.'.$i)" />
                                </div>
                            @endfor
                        </div>
                        <div class="mt-3">
                            <x-input-label for="correct_choice" :value="__('Correct Choice')" />
                            <select id="correct_choice" name="correct_choice" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">
                                @for ($i = 0; $i < 6; $i++)
                                    <option value="{{ $i }}" @selected(old('correct_choice') == $i)>{{ __('Choice') }} {{ $i + 1 }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('correct_choice')" class="mt-2" />
                            <x-input-error :messages="$errors->get('choices')" class="mt-2" />
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
