<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    //Menampilkan semua activity log
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        //FILTER BERDASARKAN TANGGAL (OPSIONAL)
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        //FILTER BERDASARKAN USER (OPSIONAL)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->get();

        return view('admin.activity-log.index', compact('logs'));
    }
}