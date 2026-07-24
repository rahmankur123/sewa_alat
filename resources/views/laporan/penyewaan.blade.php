@extends('layouts.app')
@section('title','Laporan Penyewaan')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Laporan Penyewaan
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Detail transaksi penyewaan dan denda
            </p>
        </div>

        {{-- EXPORT --}}
        <a href="{{ route(auth()->user()->role . '.laporan.penyewaan.pdf', request()->query()) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-2xl shadow-sm transition text-sm font-medium">

            Export PDF

        </a>

    </div>

    {{-- FILTER --}}
    <form method="GET"
          class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- TANGGAL AWAL --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Tanggal Awal
                </label>

                <input type="date"
                       name="tanggal_awal"
                       value="{{ request('tanggal_awal') }}"
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition">
            </div>

            {{-- TANGGAL AKHIR --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Tanggal Akhir
                </label>

                <input type="date"
                       name="tanggal_akhir"
                       value="{{ request('tanggal_akhir') }}"
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition">
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition">

                    <option value="">Semua Status</option>

                    <option value="dipinjam"
                        {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                        Dipinjam
                    </option>

                    <option value="selesai"
                        {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                    <option value="terdenda"
                        {{ request('status') == 'terdenda' ? 'selected' : '' }}>
                        Terdenda
                    </option>

                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex items-end gap-2">

                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-2xl bg-red-500 hover:bg-red-600 cursor-pointer text-white text-sm font-medium shadow-sm transition">

                    Filter

                </button>

                <a href="{{ url(auth()->user()->role . '/laporan/penyewaan') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition">

                    Reset

                </a>

            </div>

        </div>

    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-slate-50 border-b border-slate-100">

                    <tr class="text-slate-500 uppercase text-xs tracking-wide">

                        <th class="px-6 py-4 text-left font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Penyewa & Detail Barang
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Pembayaran
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

@forelse($data as $t)

@php
    $dendaTerlambat =
        $t->keterlambatan?->sum('total_denda') ?? 0;

    $dendaRusak =
        $t->kerusakan?->sum('total_denda') ?? 0;

    $dendaHilang =
        $t->hilang?->sum('denda') ?? 0;

    $totalDenda =
        $dendaTerlambat +
        $dendaRusak +
        $dendaHilang;

    $totalBayar =
        $t->total_harga + $totalDenda;

    $totalQty =
        $t->detail?->sum('qty') ?? 0;
@endphp

<tr class="hover:bg-slate-50 transition">

    {{-- TANGGAL --}}
    <td class="px-6 py-4 whitespace-nowrap text-slate-600">
        {{ \Carbon\Carbon::parse($t->tanggal_kembali_real ?? $t->created_at)->translatedFormat('d F Y') }}
    </td>

    {{-- PENYEWA + DETAIL --}}
    <td class="px-6 py-4">

        <div class="font-semibold text-slate-700 mb-2">
            {{ $t->user->name ?? '-' }}
        </div>

        {{-- DETAIL BARANG --}}
        <div class="flex flex-wrap gap-2">

            @foreach($t->detail as $detail)

            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">

                {{ $detail->barang->nama_barang ?? '-' }}
                (x{{ $detail->qty }})

            </span>

            @endforeach

        </div>

    </td>

    {{-- STATUS --}}
    <td class="px-6 py-4 text-center">

        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold capitalize

            {{ $t->status_transaksi == 'dipinjam'
                ? 'bg-blue-100 text-blue-600'
                : '' }}

            {{ $t->status_transaksi == 'selesai'
                ? 'bg-emerald-100 text-emerald-600'
                : '' }}

            {{ $t->status_transaksi == 'terdenda'
                ? 'bg-red-100 text-red-600'
                : '' }}
        ">

            {{ str_replace('_',' ',$t->status_transaksi) }}

        </span>

    </td>

    {{-- DETAIL PEMBAYARAN --}}
    <td class="px-6 py-4">

        <div class="space-y-1 text-sm">

            <div class="flex justify-between gap-4">
                <span class="text-slate-500">
                    Qty Barang
                </span>

                <span class="font-medium text-slate-700">
                    {{ $totalQty }}
                </span>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-500">
                    Total Sewa
                </span>

                <span class="font-medium text-slate-700">
                    Rp {{ number_format($t->total_harga,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-500">
                    Total Denda
                </span>

                <span class="{{ $totalDenda > 0 ? 'text-red-500 font-semibold' : 'text-slate-400' }}">
                    Rp {{ number_format($totalDenda,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between gap-4 border-t pt-2 mt-2">

                <span class="font-semibold text-slate-700">
                    Total Bayar
                </span>

                <span class="font-bold text-indigo-600">
                    Rp {{ number_format($totalBayar,0,',','.') }}
                </span>

            </div>

        </div>

    </td>

</tr>

@empty

<tr>
    <td colspan="4"
        class="text-center py-14 text-slate-400">

        Tidak ada data laporan

    </td>
</tr>

@endforelse

</tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $data->links() }}
    </div>

</div>

@endsection