@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold tracking-tight text-slate-800">
            Dashboard
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Ringkasan aktivitas transaksi dan data penyewaan
        </p>

    </div>

{{-- STAT CARD --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- TOTAL BARANG --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Barang
                </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">
                    {{ $total_barang }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                📦
            </div>

        </div>
    </div>

    {{-- TOTAL ANGGOTA --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Anggota
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ $total_anggota }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-2xl">
                👥
            </div>

        </div>
    </div>

    {{-- TOTAL TRANSAKSI --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Transaksi
                </p>

                <h2 class="text-3xl font-bold text-cyan-600 mt-2">
                    {{ $total_transaksi }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-100 text-2xl">
                📑
            </div>

        </div>
    </div>

    {{-- PENDAPATAN BULAN INI --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Pendapatan
                </p>

                <h2 class="text-2xl font-bold text-emerald-600 mt-2">
                    Rp {{ number_format($total_pendapatan,0,',','.') }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                💵
            </div>

        </div>
    </div>

    {{-- TRANSAKSI HARI INI --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Transaksi Hari Ini
                </p>

                <h2 class="text-3xl font-bold text-orange-500 mt-2">
                    {{ $transaksi_hari_ini }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-100 text-2xl">
                📅
            </div>

        </div>
    </div>

    {{-- TOTAL PENDAPATAN --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Pendapatan Bulan Ini
                </p>

                <h2 class="text-2xl font-bold text-green-600 mt-2">
                    Rp {{ number_format($pendapatan_bulan_ini,0,',','.') }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-2xl">
                💰
            </div>

        </div>
    </div>

    {{-- SEDANG BERJALAN --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Sedang Berjalan
                </p>

                <h2 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $sedang_berjalan }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-2xl">
                🔄
            </div>

        </div>
    </div>

    {{-- MASIH ADA DENDA --}}
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Masih Ada Denda
                </p>

                <h2 class="text-3xl font-bold text-red-600 mt-2">
                    {{ $terdenda }}
                </h2>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-2xl">
                ⚠️
            </div>

        </div>
    </div>

</div>


    {{-- TRANSAKSI TERBARU --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER TABLE --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

            <div>

                <h3 class="text-lg font-semibold text-slate-800">
                    Transaksi Terbaru
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Aktivitas transaksi terbaru pengguna
                </p>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Tanggal
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($latest as $t)

                    <tr class="hover:bg-slate-50/70 transition duration-200">

                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="h-11 w-11 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 font-semibold">
                                    {{ strtoupper(substr($t->user->name,0,1)) }}
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $t->user->name }}
                                </div>

                            </div>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5 text-center">

                            <span class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold capitalize

                                {{ $t->status_transaksi=='dipinjam' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $t->status_transaksi=='selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $t->status_transaksi=='dikembalikan' ? 'bg-slate-100 text-slate-700' : '' }}
                                {{ $t->status_transaksi=='tersewa' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $t->status_transaksi=='terdenda' ? 'bg-red-100 text-red-700' : '' }}">

                                {{ str_replace('_',' ',$t->status_transaksi) }}

                            </span>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-5 text-center text-slate-600 font-medium">
                            {{ $t->created_at->format('d M Y') }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="py-16 text-center">

                            <div class="flex flex-col items-center justify-center text-slate-400">

                                <div class="mb-3 text-5xl">
                                    📭
                                </div>

                                <p class="text-sm font-medium">
                                    Belum ada transaksi
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