
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - Sistem Absensi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-lg p-8">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    Buat Akun
                </h1>

                <p class="text-gray-500 mt-2">
                    Sistem Absensi Facial Biometric
                </p>
            </div>

            {{-- Pesan error --}}
            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('register.process') }}"
                method="POST"
                class="space-y-5"
            >
                @csrf

                {{-- Nama --}}
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                {{-- Username --}}
                <div>
                    <label
                        for="username"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                        placeholder="Masukkan username"
                    >
                </div>

                {{-- Email --}}
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Email
                        <span class="text-gray-400">(opsional)</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                        placeholder="contoh@email.com"
                    >
                </div>

                {{-- Formasi --}}
                <div>
                    <label
                        for="formation_id"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Formasi
                    </label>

                    <select
                        id="formation_id"
                        name="formation_id"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                    >
                        <option value="">
                            Pilih Formasi
                        </option>

                        @foreach($formations as $formation)
                            <option
                                value="{{ $formation->id }}"
                                {{ old('formation_id') == $formation->id ? 'selected' : '' }}
                            >
                                {{ $formation->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('formation_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                        placeholder="Masukkan ulang password"
                    >
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
                >
                    Daftar
                </button>
            </form>

            <div class="text-center mt-6">

                <p class="text-sm text-gray-500">
                    Sudah memiliki akun?
                    <a
                        href="{{ route('login') }}"
                        class="text-blue-600 hover:text-blue-700 font-semibold"
                    >
                        Login
                    </a>
                </p>

            </div>

        </div>

    </div>

</body>
</html>
