@extends('layouts.dashboard')

@section('title', 'Data Absensi')

@section('page-title', 'Data Absensi')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            Data Absensi
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Data absensi seluruh pengguna
        </p>
    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        {{-- Total --}}
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Total Data Absensi
            </p>

            <p class="mt-1 text-2xl font-bold text-gray-800">
                {{ $attendances->count() }}
            </p>

        </div>


        {{-- Tepat Waktu --}}
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Tepat Waktu
            </p>

            <p class="mt-1 text-2xl font-bold text-green-600">
                {{ $attendances->where('status_masuk', 'Tepat Waktu')->count() }}
            </p>

        </div>


        {{-- Terlambat --}}
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Terlambat
            </p>

            <p class="mt-1 text-2xl font-bold text-red-600">
                {{ $attendances->where('status_masuk', 'Terlambat')->count() }}
            </p>

        </div>

    </div>


    {{-- Tabel --}}
    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full whitespace-nowrap text-left text-sm">

                <thead class="border-b bg-gray-50">

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


                <tbody class="divide-y">

                    @forelse($attendances as $attendance)

                        <tr class="transition hover:bg-gray-50">

                            {{-- Nomor --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            {{-- Nama --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-800">
                                    {{ $attendance->user->name ?? '-' }}
                                </div>

                                <div class="mt-0.5 text-xs text-gray-400">
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

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Tepat Waktu
                                    </span>

                                @elseif($attendance->status_masuk === 'Terlambat')

                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                        Terlambat
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
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

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Sesuai
                                    </span>

                                @elseif($attendance->status_keluar === 'Terlalu Cepat')

                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                        Terlalu Cepat
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
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

                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
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