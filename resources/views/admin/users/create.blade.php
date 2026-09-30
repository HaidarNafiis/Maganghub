@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('page-title', 'Tambah User')

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Tambah User
        </h2>

        <form
            action="{{ route('admin.users.store') }}"
            method="POST"
            class="space-y-5"
        >

            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >

                @error('name')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg"
                    required
                >

                @error('username')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg"
                >

                @error('email')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg"
                    required
                >

                <p class="text-xs text-gray-500 mt-1">
                    Minimal 8 karakter.
                </p>

                @error('password')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Role
                </label>

                <select
                    name="role"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg"
                    required
                >
                    <option value="">-- Pilih Role --</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                        User
                    </option>

                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>

                @error('role')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Button --}}
            <div class="flex gap-3 pt-4">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                    Simpan User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection