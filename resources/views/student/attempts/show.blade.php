<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ $attempt->exam->title }}
            </h2>
            @if ($attempt->isSubmitted())
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                        {{ __('Auto score') }} {{ $attempt->auto_score ?? 0 }} / {{ $attempt->auto_total_points ?? 0 }}
                    </span>
                    <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        {{ __('Text answers recorded') }}: {{ $attempt->text_pending_count ?? 0 }}
                    </span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($attempt->isExpired())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-700 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-200">
                    {{ __('This attempt has expired.') }}
                </div>
                <a href="{{ route('student.exams.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                    {{ __('Back to Exams') }}
                </a>
            @elseif (! $attempt->isSubmitted())
                @if ($attempt->ends_at)
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-700 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200">
                        {{ __('Time remaining') }}: <span data-countdown data-ends-at="{{ $attempt->ends_at->toIso8601String() }}">--:--</span>
                    </div>
                @endif
                <form method="POST" action="{{ route('student.attempts.submit', $attempt) }}" class="space-y-6">
                    @csrf
                    @foreach ($attempt->exam->questions as $question)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                            <p class="text-sm font-semibold text-slate-400">{{ __('Question') }} {{ $loop->iteration }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $question->question_text }}</h3>
                            <div class="mt-4 space-y-3">
                                @if ($question->type === 'mcq')
                                    @foreach ($question->choices as $choice)
                                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 transition hover:border-indigo-500 dark:border-slate-700 dark:text-slate-300">
                                            <input
                                                type="radio"
                                                name="answers[{{ $question->id }}][selected_choice_id]"
                                                value="{{ $choice->id }}"
                                                class="text-indigo-600 focus:ring-indigo-500"
                                                @checked(old('answers.'.$question->id.'.selected_choice_id', optional($answers->get($question->id))->selected_choice_id) == $choice->id)
                                            />
                                            <span>{{ $choice->text }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <textarea name="answers[{{ $question->id }}][text_answer]" rows="3" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">{{ old('answers.'.$question->id.'.text_answer', optional($answers->get($question->id))->text_answer) }}</textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="flex items-center justify-between">
                        <a href="{{ route('student.exams.show', $attempt->exam) }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            {{ __('Back') }}
                        </a>
                        <button type="submit" class="rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Submit Exam') }}
                        </button>
                    </div>
                </form>
            @else
                @foreach ($attempt->exam->questions as $question)
                    @php
                        $answer = $answers->get($question->id);
                        $selected = $answer?->selected_choice_id;
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <p class="text-sm font-semibold text-slate-400">{{ __('Question') }} {{ $loop->iteration }}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $question->question_text }}</h3>
                        <div class="mt-4 space-y-3">
                            @if ($question->type === 'mcq')
                                @foreach ($question->choices as $choice)
                                    @php
                                        $isCorrect = $choice->is_correct;
                                        $isSelected = $selected === $choice->id;
                                    @endphp
                                    <div class="flex items-center gap-3 rounded-xl border px-4 py-3 text-sm {{ $isCorrect ? 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-200' : ($isSelected ? 'border-rose-300 bg-rose-50 text-rose-700 dark:border-rose-700 dark:bg-rose-950 dark:text-rose-200' : 'border-slate-200 text-slate-600 dark:border-slate-700 dark:text-slate-300') }}">
                                        <span class="h-2 w-2 rounded-full {{ $isCorrect ? 'bg-emerald-500' : ($isSelected ? 'bg-rose-500' : 'bg-slate-400') }}"></span>
                                        <span>{{ $choice->text }}</span>
                                        @if ($isCorrect)
                                            <span class="ml-auto text-xs font-semibold">{{ __('Correct') }}</span>
                                        @elseif ($isSelected)
                                            <span class="ml-auto text-xs font-semibold">{{ __('Your Answer') }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-600 dark:border-slate-700 dark:text-slate-300">
                                    {{ $answer?->text_answer ?? __('No response.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <a href="{{ route('student.exams.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                    {{ __('Back to Exams') }}
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
