<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\Request;

class EmailLogController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $type = $request->query('type');

        $logs = EmailLog::query()
            ->with('recipient')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($type, fn ($query) => $query->where('type', 'like', '%'.$type.'%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.email-logs.index', compact('logs', 'status', 'type'));
    }
}
