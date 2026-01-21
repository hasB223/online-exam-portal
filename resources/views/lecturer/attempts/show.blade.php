<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <x-breadcrumbs :items="[
                ['label' => __('Dashboard'), 'url' => route('lecturer.dashboard')],
                ['label' => __('Manage Exams'), 'url' => route('lecturer.exams.index')],
                ['label' => __('Attempts'), 'url' => route('lecturer.exams.attempts.index', $attempt->exam)],
                ['label' => __('Review'), 'url' => null],
            ]" />
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                    {{ __('Grading') }} — {{ $attempt->exam->title }}
                </h2>
                @if ($attempt->isGraded())
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                        {{ __('Graded') }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="grid gap-4 text-sm text-slate-600 dark:text-slate-300 sm:grid-cols-2">
                    <div>{{ __('Student') }}: <span class="font-semibold text-slate-900 dark:text-white">{{ $attempt->student?->name }}</span></div>
                    <div>{{ __('Status') }}: {{ ucfirst($attempt->status) }}</div>
                    <div>{{ __('Auto score') }}: {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}</div>
                    <div>{{ __('Final score') }}: {{ $attempt->final_score ?? '-' }} / {{ $attempt->final_total_points ?? '-' }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('lecturer.attempts.update', $attempt) }}" class="space-y-6">
                @csrf
                @method('put')

                @foreach ($attempt->exam->questions as $question)
                    @php
                        $answer = $answers->get($question->id);
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <p class="text-sm font-semibold text-slate-400">{{ __('Question') }} {{ $loop->iteration }}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $question->question_text }}</h3>

                        @if ($question->type === 'mcq')
                            <div class="mt-4 space-y-3 text-sm">
                                @foreach ($question->choices as $choice)
                                    @php
                                        $isCorrect = $choice->is_correct;
                                        $isSelected = $answer?->selected_choice_id === $choice->id;
                                    @endphp
                                    <div class="flex items-center gap-3 rounded-xl border px-4 py-3 {{ $isCorrect ? 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-200' : ($isSelected ? 'border-amber-300 bg-amber-50 text-amber-700 dark:border-amber-700 dark:bg-amber-950 dark:text-amber-200' : 'border-slate-200 text-slate-600 dark:border-slate-700 dark:text-slate-300') }}">
                                        <span class="h-2 w-2 rounded-full {{ $isCorrect ? 'bg-emerald-500' : ($isSelected ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                        <span>{{ $choice->text }}</span>
                                        @if ($isCorrect)
                                            <span class="ml-auto text-xs font-semibold">{{ __('Correct') }}</span>
                                        @elseif ($isSelected)
                                            <span class="ml-auto text-xs font-semibold">{{ __('Selected') }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-4 space-y-3">
                                <div class="rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 dark:border-slate-700 dark:text-slate-300">
                                    {{ $answer?->text_answer ?? __('No response.') }}
                                </div>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <x-input-label for="text_score_{{ $question->id }}" :value="__('Text score')" />
                                        <x-text-input
                                            id="text_score_{{ $question->id }}"
                                            name="text_scores[{{ $question->id }}]"
                                            type="number"
                                            min="0"
                                            max="{{ $question->points }}"
                                            class="mt-1 block w-full"
                                            :value="old('text_scores.'.$question->id, $answer?->text_score)"
                                        />
                                        <x-input-error :messages="$errors->get('text_scores.'.$question->id)" class="mt-2" />
                                    </div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ __('Max points') }}: {{ $question->points }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="flex items-center justify-between">
                    <a href="{{ route('lecturer.exams.attempts.index', $attempt->exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                        {{ __('Back') }}
                    </a>
                    <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        {{ __('Save grading') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
