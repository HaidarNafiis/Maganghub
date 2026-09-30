@extends('layouts.dashboard')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Daftar User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data pengguna sistem absensi.
            </p>
        </div>

        <a
            href="{{ route('admin.users.create') }}"
            class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
            + Tambah User
        </a>

    </div>


    {{-- Alert --}}
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Nama
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Username
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Email
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600">
                            Role
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->username }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                @if($user->role === 'superadmin')

                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                                        Super Admin
                                    </span>

                                @elseif($user->role === 'admin')

                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                        Admin
                                    </span>

                                @else

                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        User
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="px-3 py-1.5 text-sm bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200"
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
                                colspan="6"
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                Belum ada data user.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection