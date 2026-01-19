<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
            {{ __('Create Exam') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="POST" action="{{ route('lecturer.exams.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="class_room_id" :value="__('Class')" />
                            <select id="class_room_id" name="class_room_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950" data-class-room-select>
                                <option value="">{{ __('Select class') }}</option>
                                @foreach ($classRooms as $classRoom)
                                    <option value="{{ $classRoom->id }}" @selected(old('class_room_id') == $classRoom->id)>{{ $classRoom->name }}</option>
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
                                        @selected(old('subject_id') == $subjectId)>
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
                            <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('duration_minutes')" />
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                        </div>
                        <label class="mt-7 inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                            <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700" />
                            {{ __('Publish now') }}
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('lecturer.exams.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Save Exam') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
