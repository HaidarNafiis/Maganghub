@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')

{{-- Background halaman --}}
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
    ></div>


    {{-- Modal --}}
    <div
        class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl
               border border-gray-100 overflow-hidden"
    >

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Edit User
                </h2>

                <p class="text-xs text-gray-500 mt-0.5">
                    Perbarui data pengguna
                </p>
            </div>

            <a
                href="{{ route('admin.users.index') }}"
                class="flex items-center justify-center w-8 h-8
                       rounded-lg text-gray-400
                       hover:text-gray-700 hover:bg-gray-100 transition"
            >
                ✕
            </a>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('admin.users.update', $user) }}"
            method="POST"
            class="p-5"
        >

            @csrf
            @method('PUT')


            <div class="space-y-4">


                {{-- Nama --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1.5"
                    >
                        Nama
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-lg border border-gray-300
                               px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               focus:outline-none"
                        placeholder="Nama lengkap"
                    >

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Username --}}
                <div>

                    <label
                        for="username"
                        class="block text-sm font-medium text-gray-700 mb-1.5"
                    >
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username', $user->username) }}"
                        required
                        class="w-full rounded-lg border border-gray-300
                               px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               focus:outline-none"
                        placeholder="Username"
                    >

                    @error('username')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-1.5"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full rounded-lg border border-gray-300
                               px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               focus:outline-none"
                        placeholder="Email"
                    >

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Formasi --}}
                <div>

                    <label
                        for="formation_id"
                        class="block text-sm font-medium text-gray-700 mb-1.5"
                    >
                        Formasi
                    </label>

                    <select
                        id="formation_id"
                        name="formation_id"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               focus:outline-none"
                    >

                        <option value="">
                            Pilih Formasi
                        </option>

                        @foreach($formations as $formation)

                            <option
                                value="{{ $formation->id }}"
                                {{ old('formation_id', $user->formation_id) == $formation->id ? 'selected' : '' }}
                            >
                                {{ $formation->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('formation_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Role --}}
                @if(auth()->user()->role === 'superadmin')

                    <div>

                        <label
                            for="role"
                            class="block text-sm font-medium text-gray-700 mb-1.5"
                        >
                            Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                            class="w-full rounded-lg border border-gray-300
                                   bg-white px-3 py-2.5 text-sm
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-100
                                   focus:outline-none"
                        >

                            <option
                                value="user"
                                {{ old('role', $user->role) === 'user' ? 'selected' : '' }}
                            >
                                User
                            </option>

                            <option
                                value="admin"
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="superadmin"
                                {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}
                            >
                                Super Admin
                            </option>

                        </select>

                        @error('role')
                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                @else

                    {{-- Role untuk Admin --}}
                    <div>

                        <label
                            class="block text-sm font-medium text-gray-700 mb-1.5"
                        >
                            Role
                        </label>

                        <input
                            type="text"
                            value="User"
                            disabled
                            class="w-full rounded-lg border border-gray-200
                                   bg-gray-100 px-3 py-2.5
                                   text-sm text-gray-500
                                   cursor-not-allowed"
                        >

                    </div>

                @endif


                {{-- Password --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-1.5"
                    >
                        Password Baru
                        <span class="text-gray-400 font-normal">
                            (opsional)
                        </span>
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-lg border border-gray-300
                               px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               focus:outline-none"
                        placeholder="Kosongkan jika tidak diubah"
                    >

                    @error('password')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Footer --}}
            <div class="flex justify-end gap-2 mt-5 pt-4 border-t border-gray-100">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 rounded-lg
                           border border-gray-300
                           text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg
                           bg-blue-600
                           text-sm font-medium text-white
                           hover:bg-blue-700 transition
                           focus:outline-none
                           focus:ring-2 focus:ring-blue-200"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection