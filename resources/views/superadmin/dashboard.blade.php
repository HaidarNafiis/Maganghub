@extends('layouts.dashboard')

@section('title', 'Dashboard Super Admin')

@section('page-title', 'Dashboard Super Admin')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-900">
        Dashboard Super Admin
    </h1>

    <p class="mt-1 text-sm text-slate-500">
        Kelola sistem, administrator, pengguna, dan data absensi.
    </p>

</div>


<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Total User
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Total Admin
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Hadir Hari Ini
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>


    <div class="rounded-xl bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">
            Total Absensi
        </p>

        <p class="mt-2 text-3xl font-bold">
            0
        </p>
    </div>

</div>


<div class="mt-6 grid gap-6 lg:grid-cols-2">

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <h2 class="text-lg font-semibold">
            Manajemen Pengguna
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Kelola akun user yang menggunakan sistem absensi.
        </p>

        <a
            href="#"
            class="mt-5 inline-block rounded-lg bg-slate-900 px-4 py-2 text-sm text-white"
        >
            Kelola User
        </a>

    </div>


    <div class="rounded-xl bg-white p-6 shadow-sm">

        <h2 class="text-lg font-semibold">
            Manajemen Admin
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Kelola akun administrator sistem.
        </p>

        <a
            href="#"
            class="mt-5 inline-block rounded-lg bg-slate-900 px-4 py-2 text-sm text-white"
        >
            Kelola Admin
        </a>

    </div>

</div>

@endsection