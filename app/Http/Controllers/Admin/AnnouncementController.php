<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::query()
            ->latest()
            ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        Announcement::create([
            ...$request->validated(),
            'is_active' => (bool) $request->input('is_active'),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', __('Announcement created.'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update([
            ...$request->validated(),
            'is_active' => (bool) $request->input('is_active'),
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', __('Announcement updated.'));
    }
}
