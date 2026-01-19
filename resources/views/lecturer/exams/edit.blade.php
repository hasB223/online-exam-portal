<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ __('Edit Exam') }}
            </h2>
            <a href="{{ route('lecturer.questions.create', $exam) }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                {{ __('Add Question') }}
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <form method="POST" action="{{ route('lecturer.exams.update', $exam) }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $exam->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">{{ old('description', $exam->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="starts_at" :value="__('Starts At')" />
                                <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full" :value="old('starts_at', optional($exam->starts_at)->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="ends_at" :value="__('Ends At')" />
                                <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full" :value="old('ends_at', optional($exam->ends_at)->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('ends_at')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                                <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('duration_minutes', $exam->duration_minutes)" />
                                <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                            </div>
                            <label class="mt-7 inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700" @checked(old('is_published', $exam->is_published)) />
                                {{ __('Published') }}
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('lecturer.exams.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                                {{ __('Back') }}
                            </a>
                            <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                {{ __('Update Exam') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Exam Summary') }}</h3>
                    <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li>{{ __('Questions') }}: {{ $exam->questions->count() }}</li>
                        <li>{{ __('Status') }}: {{ $exam->is_published ? __('Published') : __('Draft') }}</li>
                        <li>{{ __('Duration') }}: {{ $exam->duration_minutes ? $exam->duration_minutes.' '.__('minutes') : __('No limit') }}</li>
                    </ul>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Questions') }}</h3>
                <div class="mt-4 space-y-4">
                    @forelse ($exam->questions as $question)
                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $question->prompt }}</p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('Points') }}: {{ $question->points }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('lecturer.questions.edit', [$exam, $question]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                        {{ __('Edit') }}
                                    </a>
                                    <form method="POST" action="{{ route('lecturer.questions.destroy', [$exam, $question]) }}" onsubmit="return confirm('{{ __('Delete this question?') }}')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-500">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-3 grid gap-2 text-sm text-slate-600 dark:text-slate-400">
                                @foreach ($question->options as $index => $option)
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full {{ $index === $question->correct_option ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                        <span>{{ $option }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ __('No questions yet. Add your first question to publish the exam.') }}
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
