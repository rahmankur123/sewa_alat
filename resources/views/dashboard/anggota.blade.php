@extends('layouts.app')
@section('title','Dashboard Saya')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold tracking-tight text-slate-800">
            Dashboard Saya
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Ringkasan aktivitas penyewaan dan transaksi Anda
        </p>

    </div>

    {{-- STAT CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">

        {{-- TOTAL SEWA --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Total Sewa
                    </p>

                    <h2 class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $total }}
                    </h2>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                    📦
                </div>

            </div>

        </div>

        {{-- DIPINJAM --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Sedang Dipinjam
                    </p>

                    <h2 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $dipinjam }}
                    </h2>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-2xl">
                    ⏳
                </div>

            </div>

        </div>

        {{-- TERDENDA --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Transaksi Terdenda
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

    {{-- RIWAYAT --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER TABLE --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

            <div>

                <h3 class="text-lg font-semibold text-slate-800">
                    Riwayat Terakhir
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Aktivitas transaksi terbaru Anda
                </p>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">
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

                        {{-- STATUS --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold capitalize

                                {{ $t->status_transaksi=='dipinjam' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $t->status_transaksi=='selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
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

                        <td colspan="2" class="py-16 text-center">

                            <div class="flex flex-col items-center justify-center text-slate-400">

                                <div class="mb-3 text-5xl">
                                    📭
                                </div>

                                <p class="text-sm font-medium">
                                    Belum ada riwayat transaksi
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