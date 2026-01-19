<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRoomRequest;
use App\Http\Requests\UpdateClassRoomRequest;
use App\Models\ClassRoom;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classRooms = ClassRoom::query()
            ->latest()
            ->get();

        return view('admin.classes.index', compact('classRooms'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(StoreClassRoomRequest $request)
    {
        ClassRoom::create($request->validated());

        return redirect()
            ->route('admin.classes.index')
            ->with('status', __('Class created.'));
    }

    public function edit(ClassRoom $class)
    {
        return view('admin.classes.edit', ['classRoom' => $class]);
    }

    public function update(UpdateClassRoomRequest $request, ClassRoom $class)
    {
        $class->update($request->validated());

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
