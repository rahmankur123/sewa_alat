@extends('layouts.app')
@section('title','Laporan Kerusakan')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Laporan Kerusakan
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Data kerusakan barang penyewaan
            </p>
        </div>

        <a href="{{ route(auth()->user()->role . '.laporan.kerusakan.pdf', request()->query()) }}"
           class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">
            Export PDF
        </a>

    </div>

    {{-- FILTER --}}
    <form method="GET"
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            {{-- TANGGAL AWAL --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Tanggal Awal
                </label>

                <input type="date"
                       name="tanggal_awal"
                       value="{{ request('tanggal_awal') }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>

            {{-- TANGGAL AKHIR --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Tanggal Akhir
                </label>

                <input type="date"
                       name="tanggal_akhir"
                       value="{{ request('tanggal_akhir') }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>


            {{-- BUTTON --}}
            <div class="flex gap-2">

                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 cursor-pointer text-white px-4 py-2.5 rounded-xl text-sm font-medium transition">
                    Filter
                </button>

                <a href="{{ url(auth()->user()->role . '/laporan/kerusakan') }}"
                   class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium text-center transition">
                    Reset
                </a>

            </div>

        </div>

    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Penyewa</th>
                        <th class="px-6 py-4 text-left">Barang Rusak</th>
                        <th class="px-6 py-4 text-center">Qty</th>
                        <th class="px-6 py-4 text-center">Jenis</th>
                        <th class="px-6 py-4 text-right">Total Denda</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($data as $t)

                    @php
                        $totalQty = $t->kerusakan?->sum('qty') ?? 0;
                        $totalDenda = $t->kerusakan?->sum('total_denda') ?? 0;

                        $barangRusak = $t->kerusakan
                            ? $t->kerusakan->pluck('barang.nama_barang')->implode(', ')
                            : '-';

                        $jenisKerusakan = $t->kerusakan
                            ? $t->kerusakan->pluck('jenis_kerusakan')->map(function($j){
                                return ucfirst($j);
                              })->implode(', ')
                            : '-';
                    @endphp

                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($t->tanggal_kembali)->translatedFormat('d F Y') }}
                        </td>

                        {{-- PENYEWA --}}
                        <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                            {{ $t->user->name ?? '-' }}
                        </td>

                        {{-- BARANG --}}
                        <td class="px-6 py-4 text-slate-600">
                            {{ $barangRusak }}
                        </td>

                        {{-- QTY --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-semibold">
                                {{ $totalQty }}
                            </span>
                        </td>

                        {{-- JENIS --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ str_contains(strtolower($jenisKerusakan), 'berat')
                                    ? 'bg-red-100 text-red-600'
                                    : 'bg-orange-100 text-orange-600' }}">
                                {{ $jenisKerusakan }}
                            </span>
                        </td>

                        {{-- TOTAL DENDA --}}
                        <td class="px-6 py-4 text-right font-semibold text-red-600 whitespace-nowrap">
                            Rp {{ number_format($totalDenda,0,',','.') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-14 text-slate-400">
                            Tidak ada data kerusakan
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