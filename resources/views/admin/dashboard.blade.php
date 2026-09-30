@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-900">
        Dashboard Admin
    </h1>

    <p class="mt-1 text-sm text-slate-500">
        Kelola pengguna dan monitoring data absensi.
    </p>

</div>


<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Total User
        </p>

        <p class="mt-2 text-3xl font-bold">
            {{ $totalUsers }}
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Hadir Hari Ini
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Terlambat
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Tidak Hadir
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>

</div>


<div class="mt-6 rounded-xl bg-white p-6 shadow-sm">

    <h2 class="text-lg font-semibold">
        Aktivitas Absensi Terbaru
    </h2>

    <div class="mt-6 overflow-x-auto">

        <table class="w-full text-left text-sm">

            <thead class="border-b bg-slate-50">

                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Jam</th>
                    <th class="px-4 py-3">Status</th>
                </tr>

            </thead>

            <tbody>

                <tr class="border-b">

                    <td class="px-4 py-4">
                        Belum ada data
                    </td>

                    <td class="px-4 py-4">
                        -
                    </td>

                    <td class="px-4 py-4">
                        -
                    </td>

                    <td class="px-4 py-4">
                        -
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection