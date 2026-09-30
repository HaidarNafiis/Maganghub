@extends('layouts.dashboard')

@section('title', 'Data Absensi')

@section('page-title', 'Data Absensi')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Data Absensi
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Data absensi seluruh pengguna
            </p>
        </div>

    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Total Data --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Total Data Absensi
            </p>

            <p class="text-2xl font-bold text-gray-800 mt-1">
                {{ $attendances->count() }}
            </p>

        </div>


        {{-- Tepat Waktu --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Tepat Waktu
            </p>

            <p class="text-2xl font-bold text-green-600 mt-1">
                {{ $attendances->where('status_masuk', 'Tepat Waktu')->count() }}
            </p>

        </div>


        {{-- Terlambat --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Terlambat
            </p>

            <p class="text-2xl font-bold text-red-600 mt-1">
                {{ $attendances->where('status_masuk', 'Terlambat')->count() }}
            </p>

        </div>

    </div>


    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left whitespace-nowrap">

                {{-- Header --}}
                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Nama
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Formasi
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Jam Masuk
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Status Masuk
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Jam Keluar
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Status Keluar
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Durasi
                        </th>

                    </tr>

                </thead>


                {{-- Isi --}}
                <tbody class="divide-y">

                    @forelse($attendances as $attendance)

                        <tr class="hover:bg-gray-50 transition">


                            {{-- Nomor --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            {{-- Nama --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-800">
                                    {{ $attendance->user->name ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ $attendance->user->username ?? '-' }}
                                </div>

                            </td>


                            {{-- Formasi --}}
                            <td class="px-6 py-4 text-gray-600">

                                {{ $attendance->user->formation?->name ?? '-' }}

                            </td>


                            {{-- Tanggal --}}
                            <td class="px-6 py-4 text-gray-600">

                                {{ $attendance->tanggal?->format('d-m-Y') ?? '-' }}

                            </td>


                            {{-- Jam Masuk --}}
                            <td class="px-6 py-4 text-gray-700">

                                {{ $attendance->jam_masuk ?? '-' }}

                            </td>


                            {{-- Status Masuk --}}
                            <td class="px-6 py-4">

                                @if($attendance->status_masuk === 'Tepat Waktu')

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Tepat Waktu
                                    </span>

                                @elseif($attendance->status_masuk === 'Terlambat')

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                        Terlambat
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                        Belum Absen
                                    </span>

                                @endif

                            </td>


                            {{-- Jam Keluar --}}
                            <td class="px-6 py-4 text-gray-700">

                                {{ $attendance->jam_keluar ?? '-' }}

                            </td>


                            {{-- Status Keluar --}}
                            <td class="px-6 py-4">

                                @if($attendance->status_keluar === 'Sesuai')

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Sesuai
                                    </span>

                                @elseif($attendance->status_keluar === 'Terlalu Cepat')

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                        Terlalu Cepat
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                        Belum Absen
                                    </span>

                                @endif

                            </td>


                            {{-- Durasi --}}
                            <td class="px-6 py-4 font-medium text-gray-700">

                                {{ $attendance->durasi_kerja }}

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="px-6 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-6 h-6 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>

                                    </div>

                                    <p class="text-gray-500">
                                        Belum ada data absensi.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection