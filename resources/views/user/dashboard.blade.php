@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Selamat datang, {{ $user->name }}. Berikut ringkasan absensi Anda.
        </p>
    </div>


    {{-- ABSENSI HARI INI --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Absensi Hari Ini
                </p>

                <p class="mt-1 text-lg font-bold text-gray-800">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>


            <div class="flex flex-wrap gap-4">

                <div>
                    <p class="text-xs text-gray-500">
                        Jam Masuk
                    </p>

                    <p class="font-bold text-gray-800">
                        {{ $today?->jam_masuk ?? '-' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs text-gray-500">
                        Jam Keluar
                    </p>

                    <p class="font-bold text-gray-800">
                        {{ $today?->jam_keluar ?? '-' }}
                    </p>
                </div>


                @if($today)

                    @if($today->status === 'terlambat')

                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            Terlambat
                        </span>

                    @else

                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Hadir
                        </span>

                    @endif

                @else

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                        Belum Absen
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- HADIR --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Hadir
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ $totalHadir }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Hari
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-2xl">
                    ✅
                </div>

            </div>

        </div>


        {{-- TERLAMBAT --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Terlambat
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-600">
                        {{ $totalTerlambat }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Kali
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-2xl">
                    ⏰
                </div>

            </div>

        </div>


        {{-- TIDAK HADIR --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Tidak Hadir
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-600">
                        {{ $totalTidakHadir }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Hari
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-2xl">
                    ❌
                </div>

            </div>

        </div>


        {{-- PERSENTASE --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Kehadiran
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $persentaseKehadiran }}%
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Persentase
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-2xl">
                    📊
                </div>

            </div>

        </div>

    </div>


    {{-- INFORMASI BULAN --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Total Absensi Bulan Ini
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-800">
                    {{ $bulanIni }} hari
                </p>
            </div>

            <div class="text-3xl">
                📅
            </div>

        </div>

    </div>


    {{-- ABSENSI TERBARU --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="font-semibold text-gray-800">
                        Riwayat Absensi Terbaru
                    </h2>

                    <p class="mt-1 text-xs text-gray-500">
                        5 data absensi terakhir
                    </p>
                </div>

                <a
                    href="{{ route('user.attendance.history') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                >
                    Lihat Semua
                </a>

            </div>

        </div>


        @if($recentAttendances->count() > 0)

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Tanggal
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Masuk
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Keluar
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Durasi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @foreach($recentAttendances as $attendance)

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4 font-medium text-gray-800">
                                    {{ $attendance->tanggal->format('d/m/Y') }}
                                </td>


                                <td class="px-5 py-4">

                                    {{ $attendance->jam_masuk
                                        ? \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i:s')
                                        : '-' }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $attendance->jam_keluar
                                        ? \Carbon\Carbon::parse($attendance->jam_keluar)->format('H:i:s')
                                        : '-' }}

                                </td>


                                <td class="px-5 py-4">

                                    @if($attendance->status === 'terlambat')

                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Terlambat
                                        </span>

                                    @elseif($attendance->status === 'hadir')

                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Hadir
                                        </span>

                                    @else

                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Tidak Hadir
                                        </span>

                                    @endif

                                </td>


                                <td class="px-5 py-4">

                                    @if($attendance->jam_masuk && $attendance->jam_keluar)

                                        {{ $attendance->durasi_kerja }}

                                    @else

                                        -

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="px-5 py-10 text-center">

                <div class="text-4xl">
                    📋
                </div>

                <p class="mt-3 font-semibold text-gray-700">
                    Belum ada data absensi
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Data absensi Anda akan muncul di sini.
                </p>

            </div>

        @endif

    </div>


    {{-- TOMBOL --}}
    <div class="flex flex-wrap gap-3">

        <a
            href="{{ route('user.attendance.index') }}"
            class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700"
        >
            📷 Absen Sekarang
        </a>

        <a
            href="{{ route('user.attendance.history') }}"
            class="rounded-xl bg-gray-100 px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-200"
        >
            📋 Riwayat Absensi
        </a>

    </div>

</div>

@endsection