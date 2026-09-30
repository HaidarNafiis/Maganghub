<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with([
            'user.formation'
        ])
        ->latest('tanggal')
        ->latest('jam_masuk')
        ->get();

        return view(
            'admin.attendances.index',
            compact('attendances')
        );
    }
}