@extends('layouts.dashboard')

@section('title', 'Formasi')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Formasi
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola formasi atau posisi pekerjaan.
            </p>
        </div>

        <a
            href="{{ route('admin.formations.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
        >
            + Tambah Formasi
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Formasi</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($formations as $formation)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $formation->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $formation->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                @if($formation->active)

                                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-600">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('admin.formations.edit', $formation) }}"
                                        class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.formations.destroy', $formation) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus formasi ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                Belum ada formasi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection