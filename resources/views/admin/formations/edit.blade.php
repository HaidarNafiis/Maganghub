@extends('layouts.dashboard')

@section('title', 'Edit Formasi')

@section('content')

<div class="max-w-2xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit Formasi
        </h1>

        <p class="text-gray-500 mt-1">
            Perbarui informasi formasi.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.formations.update', $formation) }}"
            method="POST"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Formasi
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $formation->name) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                >{{ old('description', $formation->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>

                <select
                    name="active"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                >
                    <option value="1" {{ $formation->active ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ !$formation->active ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>
            </div>

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.formations.index') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection