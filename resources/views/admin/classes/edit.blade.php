@extends('layouts.admin')

@section('header')
    <div class="space-y-2">
        <x-breadcrumbs :items="[
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Classes'), 'url' => route('admin.classes.index')],
            ['label' => __('Edit'), 'url' => null],
        ]" />
        <span>{{ __('Edit Class') }}</span>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="POST" action="{{ route('admin.classes.update', $classRoom) }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $classRoom->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="code" :value="__('Code')" />
                        <x-text-input id="code" name="code" class="mt-1 block w-full" :value="old('code', $classRoom->code)" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label :value="__('Subjects')" />
                        @php
                            $selectedSubjects = old('subjects', $classRoom->subjects->pluck('id')->all());
                        @endphp
                        <div class="mt-2 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($subjects as $subject)
                                <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700"
                                        @checked(in_array($subject->id, $selectedSubjects, true)) />
                                    <span>{{ $subject->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('subjects')" class="mt-2" />
                        <x-input-error :messages="$errors->get('subjects.*')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.classes.index') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300">
                            {{ __('Back') }}
                        </a>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
