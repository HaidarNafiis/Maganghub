<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | TOTAL ABSENSI
        |--------------------------------------------------------------------------
        */

        $totalHadir = Attendance::where('user_id', $user->id)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        $totalTerlambat = Attendance::where('user_id', $user->id)
            ->where('status', 'terlambat')
            ->count();

        $totalTidakHadir = Attendance::where('user_id', $user->id)
            ->where('status', 'tidak_hadir')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL HARI ABSENSI
        |--------------------------------------------------------------------------
        */

        $totalAbsensi = Attendance::where('user_id', $user->id)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KEHADIRAN
        |--------------------------------------------------------------------------
        */

        $persentaseKehadiran = $totalAbsensi > 0
            ? round(($totalHadir / $totalAbsensi) * 100, 1)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | ABSENSI BULAN INI
        |--------------------------------------------------------------------------
        */

        $bulanIni = Attendance::where('user_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ABSENSI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentAttendances = Attendance::where('user_id', $user->id)
            ->latest('tanggal')
            ->latest('jam_masuk')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ABSENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $today = Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();


        return view('user.dashboard', compact(
            'user',
            'totalHadir',
            'totalTerlambat',
            'totalTidakHadir',
            'totalAbsensi',
            'persentaseKehadiran',
            'bulanIni',
            'recentAttendances',
            'today'
        ));
    }
}