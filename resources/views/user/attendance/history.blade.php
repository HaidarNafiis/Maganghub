@extends('layouts.dashboard')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Riwayat Absensi
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Riwayat kehadiran, foto, dan lokasi saat melakukan absensi masuk.
        </p>
    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                Riwayat Presensi
            </h2>
        </div>


        @if($attendances->count() > 0)

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                No
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Foto
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Tanggal
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Jam Masuk
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Jam Keluar
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Durasi
                            </th>

                            <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                Lokasi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @foreach($attendances as $attendance)

                            <tr class="hover:bg-gray-50">

                                {{-- NO --}}
                                <td class="px-5 py-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- FOTO --}}
                                <td class="px-5 py-4">

                                    @if($attendance->foto)

                                        <img
                                            src="{{ asset('storage/' . $attendance->foto) }}"
                                            alt="Foto Absensi"
                                            class="h-20 w-20 rounded-lg border border-gray-200 object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-center text-xs text-gray-400"
                                        >
                                            Tidak Ada Foto
                                        </div>

                                    @endif

                                </td>


                                {{-- TANGGAL --}}
                                <td class="px-5 py-4 font-medium text-gray-800">

                                    {{ $attendance->tanggal->format('d/m/Y') }}

                                </td>


                                {{-- JAM MASUK --}}
                                <td class="px-5 py-4">

                                    @if($attendance->jam_masuk)

                                        <span class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i:s') }}
                                        </span>

                                    @else

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- JAM KELUAR --}}
                                <td class="px-5 py-4">

                                    @if($attendance->jam_keluar)

                                        <span class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($attendance->jam_keluar)->format('H:i:s') }}
                                        </span>

                                    @else

                                        <span class="text-gray-400">
                                            Belum Absen
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    @if($attendance->status === 'terlambat')

                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                                        >
                                            Terlambat
                                        </span>

                                    @elseif($attendance->status === 'hadir')

                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                                        >
                                            Hadir
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700"
                                        >
                                            Tidak Hadir
                                        </span>

                                    @endif

                                </td>


                                {{-- DURASI --}}
                                <td class="px-5 py-4">

                                    @if($attendance->jam_masuk && $attendance->jam_keluar)

                                        <span class="font-medium text-gray-700">
                                            {{ $attendance->durasi_kerja }}
                                        </span>

                                    @else

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- LOKASI --}}
                                <td class="px-5 py-4">

                                    @if($attendance->latitude && $attendance->longitude)

                                        <div class="min-w-[220px]">

                                            <div class="flex items-center gap-2">

                                                <span class="text-lg">
                                                    📍
                                                </span>

                                                <span class="font-semibold text-gray-800">
                                                    Lokasi Absen
                                                </span>

                                            </div>


                                            <div class="mt-2 space-y-1 text-xs text-gray-500">

                                                <p>
                                                    <span class="font-medium text-gray-700">
                                                        Latitude:
                                                    </span>

                                                    {{ number_format($attendance->latitude, 7) }}
                                                </p>


                                                <p>
                                                    <span class="font-medium text-gray-700">
                                                        Longitude:
                                                    </span>

                                                    {{ number_format($attendance->longitude, 7) }}
                                                </p>


                                                @if($attendance->jarak_meter !== null)

                                                    <p>
                                                        <span class="font-medium text-gray-700">
                                                            Jarak:
                                                        </span>

                                                        {{ number_format($attendance->jarak_meter, 2) }}
                                                        meter
                                                    </p>

                                                @endif


                                                @if($attendance->accuracy !== null)

                                                    <p>
                                                        <span class="font-medium text-gray-700">
                                                            Akurasi:
                                                        </span>

                                                        ±{{ number_format($attendance->accuracy, 2) }}
                                                        meter
                                                    </p>

                                                @endif

                                            </div>


                                            {{-- GOOGLE MAP --}}
                                            <a
                                                href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-3 inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                            >
                                                🗺️ Lihat di Google Maps
                                            </a>

                                        </div>

                                    @else

                                        <span class="text-gray-400">
                                            Lokasi tidak tersedia
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- EMPTY --}}
            <div class="px-5 py-12 text-center">

                <div class="text-4xl">
                    📋
                </div>

                <h3 class="mt-3 font-semibold text-gray-700">
                    Belum Ada Riwayat Absensi
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Anda belum memiliki data presensi.
                </p>

            </div>

        @endif

    </div>

</div>
@endsection