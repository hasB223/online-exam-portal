<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                {{ $attempt->exam->title }}
            </h2>
            @if ($attempt->isSubmitted())
                <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                    {{ __('Score') }} {{ $attempt->score }} / {{ $attempt->total_points }}
                </span>
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

            @if (! $attempt->isSubmitted())
                <form method="POST" action="{{ route('student.attempts.submit', $attempt) }}" class="space-y-6">
                    @csrf
                    @foreach ($attempt->exam->questions as $question)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                            <p class="text-sm font-semibold text-slate-400">{{ __('Question') }} {{ $loop->iteration }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $question->prompt }}</h3>
                            <div class="mt-4 space-y-3">
                                @foreach ($question->options as $index => $option)
                                    <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 transition hover:border-indigo-500 dark:border-slate-700 dark:text-slate-300">
                                        <input
                                            type="radio"
                                            name="answers[{{ $question->id }}]"
                                            value="{{ $index }}"
                                            class="text-indigo-600 focus:ring-indigo-500"
                                            @checked(old('answers.'.$question->id, optional($answers->get($question->id))->selected_option) == $index)
                                        />
                                        <span>{{ $option }}</span>
                                    </label>
                                @endforeach
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
                        $selected = $answer?->selected_option;
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <p class="text-sm font-semibold text-slate-400">{{ __('Question') }} {{ $loop->iteration }}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $question->prompt }}</h3>
                        <div class="mt-4 space-y-3">
                            @foreach ($question->options as $index => $option)
                                @php
                                    $isCorrect = $index === $question->correct_option;
                                    $isSelected = $selected === $index;
                                @endphp
                                <div class="flex items-center gap-3 rounded-xl border px-4 py-3 text-sm {{ $isCorrect ? 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-200' : ($isSelected ? 'border-rose-300 bg-rose-50 text-rose-700 dark:border-rose-700 dark:bg-rose-950 dark:text-rose-200' : 'border-slate-200 text-slate-600 dark:border-slate-700 dark:text-slate-300') }}">
                                    <span class="h-2 w-2 rounded-full {{ $isCorrect ? 'bg-emerald-500' : ($isSelected ? 'bg-rose-500' : 'bg-slate-400') }}"></span>
                                    <span>{{ $option }}</span>
                                    @if ($isCorrect)
                                        <span class="ml-auto text-xs font-semibold">{{ __('Correct') }}</span>
                                    @elseif ($isSelected)
                                        <span class="ml-auto text-xs font-semibold">{{ __('Your Answer') }}</span>
                                    @endif
                                </div>
                            @endforeach
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
