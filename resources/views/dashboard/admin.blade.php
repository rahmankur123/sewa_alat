@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    {{-- HEADER --}}
    <h2 class="text-2xl font-semibold text-slate-700 mb-6">
        Dashboard
    </h2>

    {{-- STAT CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        {{-- TOTAL BARANG --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Total Barang</p>
            <h2 class="text-2xl font-bold text-slate-700 mt-1">
                {{ $total_barang }}
            </h2>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Total Transaksi</p>
            <h2 class="text-2xl font-bold text-slate-700 mt-1">
                {{ $total_transaksi }}
            </h2>
        </div>

        {{-- DIPINJAM --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Sedang Dipinjam</p>
            <h2 class="text-2xl font-bold text-blue-500 mt-1">
                {{ $dipinjam }}
            </h2>
        </div>

        {{-- TERDENDA --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Transaksi Terdenda</p>
            <h2 class="text-2xl font-bold text-red-500 mt-1">
                {{ $terdenda }}
            </h2>
        </div>

    </div>

    {{-- TOTAL DENDA --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6">
        <p class="text-sm text-slate-500">Total Denda</p>
        <h2 class="text-2xl font-bold text-red-600 mt-1">
            Rp {{ number_format($total_denda,0,',','.') }}
        </h2>
    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-700">
                Transaksi Terbaru
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($latest as $t)
                    <tr class="border-t hover:bg-slate-50 transition">

                        <td class="px-6 py-4 font-medium">
                            {{ $t->user->name }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-xs rounded-full capitalize
                                {{ $t->status_transaksi=='dipinjam' ? 'bg-blue-100 text-blue-600' : '' }}
                                {{ $t->status_transaksi=='selesai' ? 'bg-green-100 text-green-600' : '' }}
                                {{ $t->status_transaksi=='terdenda' ? 'bg-red-100 text-red-600' : '' }}">
                                {{ str_replace('_',' ',$t->status_transaksi) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $t->created_at->format('d M Y') }}
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-10 text-slate-400">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection