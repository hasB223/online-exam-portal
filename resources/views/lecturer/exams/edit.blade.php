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

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="class_room_id" :value="__('Class')" />
                                <select id="class_room_id" name="class_room_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950" data-class-room-select>
                                    <option value="">{{ __('Select class') }}</option>
                                    @foreach ($classRooms as $classRoom)
                                        <option value="{{ $classRoom->id }}" @selected(old('class_room_id', $exam->class_room_id) == $classRoom->id)>{{ $classRoom->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('class_room_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="subject_id" :value="__('Subject')" />
                                <select id="subject_id" name="subject_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950" data-subject-select>
                                    <option value="">{{ __('Select subject') }}</option>
                                    @php
                                        $subjectMap = [];
                                        foreach ($classRooms as $classRoom) {
                                            foreach ($classRoom->subjects as $subject) {
                                                $subjectMap[$subject->id]['name'] = $subject->name;
                                                $subjectMap[$subject->id]['classes'][] = $classRoom->id;
                                            }
                                        }
                                    @endphp
                                    @foreach ($subjectMap as $subjectId => $subjectData)
                                        <option value="{{ $subjectId }}"
                                            data-classes="{{ implode(',', $subjectData['classes'] ?? []) }}"
                                            @selected(old('subject_id', $exam->subject_id) == $subjectId)>
                                            {{ $subjectData['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
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
                        <li>{{ __('Class') }}: {{ $exam->classRoom?->name ?? __('-') }}</li>
                        <li>{{ __('Subject') }}: {{ $exam->subject?->name ?? __('-') }}</li>
                    </ul>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ __('Questions') }}</h3>

                <form method="POST" action="{{ route('lecturer.questions.store', $exam) }}" class="mt-4 space-y-4">
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
                        <textarea id="question_text" name="question_text" rows="3" class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950">{{ old('question_text') }}</textarea>
                        <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                    </div>

                    <div data-choice-fields>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Choices') }}</p>
                        <div class="mt-2 grid gap-3 sm:grid-cols-2">
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

                    <div class="flex items-center justify-end">
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Add Question') }}
                        </button>
                    </div>
                </form>

                <div class="mt-6 space-y-4">
                    @forelse ($exam->questions as $question)
                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $question->question_text }}</p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('Points') }}: {{ $question->points }}</p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('Type') }}: {{ strtoupper($question->type) }}</p>
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
                            @if ($question->type === 'mcq')
                                <div class="mt-3 grid gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    @foreach ($question->choices as $choice)
                                        <div class="flex items-center gap-2">
                                            <span class="h-2 w-2 rounded-full {{ $choice->is_correct ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                            <span>{{ $choice->text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('Text response') }}
                                </p>
                            @endif
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
