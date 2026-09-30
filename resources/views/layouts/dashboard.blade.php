<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - Sistem Absensi
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-slate-100 text-slate-800">

<div class="min-h-screen">


    <!-- ========================================================= -->
    <!-- SIDEBAR -->
    <!-- ========================================================= -->

    <aside
        class="fixed inset-y-0 left-0 z-50 hidden w-64 bg-slate-900 text-white lg:block"
    >

        <!-- Logo -->
        <div class="flex h-16 items-center border-b border-slate-800 px-6">

            <div>

                <h1 class="text-lg font-bold">
                    Sistem Absensi
                </h1>

                <p class="text-xs text-slate-400">
                    Facial Biometric
                </p>

            </div>

        </div>


        <!-- Navigation -->
        <nav class="p-4">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Menu
            </p>


            <!-- ================================================= -->
            <!-- USER -->
            <!-- ================================================= -->

            @if(auth()->user()->role === 'user')

                <!-- Dashboard -->
                <a
                    href="{{ route('user.dashboard') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('user.dashboard') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📊
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>


                <!-- Absensi -->
                <a
                    href="{{ route('user.attendance.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('user.attendance.index') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📸
                    </span>

                    <span>
                        Absensi
                    </span>

                </a>


                <!-- Riwayat Absensi -->
               <a href="{{ route('user.attendance.history') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        <span>Riwayat Absensi</span>
                    </a>


            <!-- ================================================= -->
            <!-- ADMIN -->
            <!-- ================================================= -->

            @elseif(auth()->user()->role === 'admin')

                <!-- Dashboard -->
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📊
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>


                <!-- Data User -->
                <a
                    href="{{ route('admin.users.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        👥
                    </span>

                    <span>
                        Data User
                    </span>

                </a>


                <!-- Formasi -->
                <a
                    href="{{ route('admin.formations.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.formations.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        💼
                    </span>

                    <span>
                        Formasi
                    </span>

                </a>


                <!-- Data Absensi -->
                <a
                    href="{{ route('admin.attendances.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.attendances.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📋
                    </span>

                    <span>
                        Data Absensi
                    </span>

                </a>


            <!-- ================================================= -->
            <!-- SUPER ADMIN -->
            <!-- ================================================= -->

            @elseif(auth()->user()->role === 'superadmin')

                <!-- Dashboard -->
                <a
                    href="{{ route('superadmin.dashboard') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('superadmin.dashboard') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📊
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>


                <!-- Kelola User -->
                <a
                    href="{{ route('admin.users.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        👥
                    </span>

                    <span>
                        Kelola User
                    </span>

                </a>


                <!-- Kelola Admin -->
                <a
                    href="#"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800"
                >

                    <span class="text-lg">
                        🛡️
                    </span>

                    <span>
                        Kelola Admin
                    </span>

                </a>


                <!-- Formasi -->
                <a
                    href="{{ route('admin.formations.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.formations.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        💼
                    </span>

                    <span>
                        Formasi
                    </span>

                </a>


                <!-- Data Absensi -->
                <a
                    href="{{ route('admin.attendances.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition hover:bg-slate-800
                    {{ request()->routeIs('admin.attendances.*') ? 'bg-slate-800' : '' }}"
                >

                    <span class="text-lg">
                        📋
                    </span>

                    <span>
                        Data Absensi
                    </span>

                </a>

            @endif

        </nav>


        <!-- Sidebar Footer -->
        <div class="absolute bottom-0 left-0 right-0 border-t border-slate-800 p-4">

            <p class="text-xs text-slate-500">
                Sistem Absensi
            </p>

            <p class="text-xs text-slate-600 mt-1">
                Facial Biometric
            </p>

        </div>

    </aside>


    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <div class="lg:pl-64">


        <!-- ===================================================== -->
        <!-- TOPBAR -->
        <!-- ===================================================== -->

        <header
            class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6"
        >


            <!-- Page Title -->
            <div>

                <h2 class="font-semibold text-slate-800">
                    @yield('page-title', 'Dashboard')
                </h2>

                <p class="text-xs text-slate-500">
                    Sistem Absensi Facial Biometric
                </p>

            </div>


            <!-- ================================================= -->
            <!-- USER PROFILE -->
            <!-- ================================================= -->

            <div class="flex items-center gap-4">


                <!-- Nama & Role -->
                <div class="hidden text-right sm:block">

                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-500">

                        @if(auth()->user()->role === 'superadmin')

                            Super Admin

                        @elseif(auth()->user()->role === 'admin')

                            Admin

                        @else

                            User

                        @endif

                    </p>

                </div>


                <!-- Avatar -->
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 font-semibold text-white"
                >

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>


                <!-- Logout -->
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </header>


        <!-- ===================================================== -->
        <!-- CONTENT -->
        <!-- ===================================================== -->

        <main class="p-6">


            <!-- Success Message -->
            @if(session('success'))

                <div
                    class="mb-6 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                >

                    <span>
                        ✓
                    </span>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            <!-- Error Message -->
            @if(session('error'))

                <div
                    class="mb-6 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                >

                    <span>
                        ⚠
                    </span>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <!-- Validation Errors -->
            @if($errors->any())

                <div
                    class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700"
                >

                    <p class="font-semibold mb-2">
                        Terdapat kesalahan:
                    </p>

                    <ul class="list-disc pl-5 space-y-1">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- Page Content -->
            @yield('content')


        </main>

    </div>

</div>

</body>
</html>