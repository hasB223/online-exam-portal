<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRoomRequest;
use App\Http\Requests\UpdateClassRoomRequest;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Support\Arr;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classRooms = ClassRoom::query()
            ->with('subjects')
            ->latest()
            ->get();

        return view('admin.classes.index', compact('classRooms'));
    }

    public function create()
    {
        $subjects = Subject::query()
            ->orderBy('name')
            ->get();

        return view('admin.classes.create', compact('subjects'));
    }

    public function store(StoreClassRoomRequest $request)
    {
        $data = $request->validated();
        $subjects = $data['subjects'] ?? [];

        $classRoom = ClassRoom::create(Arr::except($data, ['subjects']));
        $classRoom->subjects()->sync($subjects);

        return redirect()
            ->route('admin.classes.index')
            ->with('status', __('Class created.'));
    }

    public function edit(ClassRoom $class)
    {
        $subjects = Subject::query()
            ->orderBy('name')
            ->get();

        $class->load('subjects');

        return view('admin.classes.edit', ['classRoom' => $class, 'subjects' => $subjects]);
    }

    public function update(UpdateClassRoomRequest $request, ClassRoom $class)
    {
        $data = $request->validated();
        $subjects = $data['subjects'] ?? [];

        $class->update(Arr::except($data, ['subjects']));
        $class->subjects()->sync($subjects);

        return redirect()
            ->route('admin.classes.index')
            ->with('status', __('Class updated.'));
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();

        return redirect()
            ->route('admin.classes.index')
            ->with('status', __('Class deleted.'));
    }
}
