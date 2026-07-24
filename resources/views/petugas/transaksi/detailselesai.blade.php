@extends('layouts.app')

@section('title','Detail Transaksi Selesai')

@section('content')

{{-- ACTION --}}
<div class="no-print mb-4 flex justify-between max-w-4xl mx-auto">

    <a href="{{ url()->previous() }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        ← Kembali
    </a>

    <button onclick="window.print()"
        class="px-4 py-2 bg-indigo-600 cursor-pointer text-white rounded-lg hover:bg-indigo-700 transition">
        🖨️ Cetak
    </button>

</div>

{{-- NOTA --}}
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-8 border-b pb-5">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Detail Transaksi Selesai
            </h2>

            <p class="text-sm text-gray-500">
                Sistem Penyewaan Alat Bela Diri
            </p>
        </div>

        <div class="text-right text-sm">

            <p class="text-gray-500">
                No Nota
            </p>

            <p class="font-bold text-gray-800">
                INV-{{ $transaksi->id }}-{{ date('Ymd') }}
            </p>

            <p class="text-gray-400">
                {{ now()->translatedFormat('d F Y') }}
            </p>

        </div>

    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm mb-8">

        <div>
            <p class="text-gray-500 mb-1">
                Nama Penyewa
            </p>

            <p class="font-semibold text-gray-800">
                {{ $transaksi->user->name }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 mb-1">
                Status
            </p>

            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                {{ ucfirst($transaksi->status_transaksi) }}
            </span>
        </div>

        <div>
            <p class="text-gray-500 mb-1">
                Tanggal Pinjam
            </p>

            <p class="text-gray-700">
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 mb-1">
                Tanggal Kembali
            </p>

            <p class="text-gray-700">
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- BARANG --}}
    <div class="mb-8">

        <h3 class="font-semibold text-gray-800 mb-3">
            Barang Disewa
        </h3>

        <div class="overflow-x-auto border border-gray-200 rounded-xl">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-xs uppercase text-gray-500">

                    <tr>
                        <th class="p-3 text-left">
                            Barang
                        </th>

                        <th class="p-3 text-center">
                            Qty
                        </th>

                        <th class="p-3 text-right">
                            Harga / Hari
                        </th>

                        <th class="p-3 text-right">
                            Subtotal
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @php $total_sewa = 0; @endphp

                    @foreach($transaksi->detail as $d)

                    @php
                        $total_sewa += $d->subtotal;
                    @endphp

                    <tr class="border-t">

                        <td class="p-3">
                            {{ $d->barang->nama_barang }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $d->qty }}
                        </td>

                        <td class="p-3 text-right">
                            Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                        </td>

                        <td class="p-3 text-right font-medium">
                            Rp {{ number_format($d->subtotal,0,',','.') }}
                        </td>

                    </tr>

                    @endforeach

                    <tr class="bg-gray-50 font-semibold border-t">

                        <td colspan="3" class="p-3 text-right">
                            Total Sewa
                        </td>

                        <td class="p-3 text-right">
                            Rp {{ number_format($total_sewa,0,',','.') }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- DENDA --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-sm mb-8">

        {{-- KETERLAMBATAN --}}
        <div class="bg-gray-50 rounded-xl p-4">

            <h4 class="font-semibold text-gray-800 mb-3">
                Keterlambatan
            </h4>

            @forelse($transaksi->keterlambatan as $k)

            <div class="flex justify-between py-2 border-b last:border-0">

                <span>
                    {{ $k->durasi_hari }} hari
                </span>

                <span class="text-red-500">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </span>

            </div>

            @empty

            <p class="text-gray-400">
                Tidak ada
            </p>

            @endforelse

        </div>

        {{-- KERUSAKAN --}}
        <div class="bg-gray-50 rounded-xl p-4">

            <h4 class="font-semibold text-gray-800 mb-3">
                Kerusakan
            </h4>

            @forelse($transaksi->kerusakan as $k)

            <div class="flex justify-between py-2 border-b last:border-0">

                <span>
                    {{ $k->barang->nama_barang }} ({{ $k->qty }})
                </span>

                <span class="text-red-500">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </span>

            </div>

            @empty

            <p class="text-gray-400">
                Tidak ada
            </p>

            @endforelse

        </div>

        {{-- KEHILANGAN --}}
        <div class="bg-gray-50 rounded-xl p-4">

            <h4 class="font-semibold text-gray-800 mb-3">
                Kehilangan
            </h4>

            @forelse($transaksi->barangHilang as $h)

            <div class="flex justify-between py-2 border-b last:border-0">

                <span>
                    {{ $h->barang->nama_barang }} ({{ $h->qty }})
                </span>

                <span class="text-red-500">
                    Rp {{ number_format($h->denda,0,',','.') }}
                </span>

            </div>

            @empty

            <p class="text-gray-400">
                Tidak ada
            </p>

            @endforelse

        </div>

    </div>

    {{-- TOTAL --}}
    @php

        $total_denda =
            $transaksi->keterlambatan->sum('total_denda') +
            $transaksi->kerusakan->sum('total_denda') +
            $transaksi->barangHilang->sum('denda');

        $grand_total = $total_sewa + $total_denda;

    @endphp

    <div class="bg-gray-100 rounded-xl p-5">

        <div class="flex justify-between text-sm mb-2">

            <span>
                Total Sewa
            </span>

            <span>
                Rp {{ number_format($total_sewa,0,',','.') }}
            </span>

        </div>

        <div class="flex justify-between text-sm mb-2">

            <span>
                Total Denda
            </span>

            <span class="text-red-500">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>

        </div>

        <div class="flex justify-between font-bold text-lg border-t pt-3 mt-3">

            <span>
                Total Bayar
            </span>

            <span class="text-gray-800">
                Rp {{ number_format($grand_total,0,',','.') }}
            </span>

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between text-sm">

        <div class="text-gray-500">
            Terima kasih telah menggunakan layanan kami
        </div>

        <div class="text-right">

            <p>
                Petugas
            </p>

            <br><br>

            <p class="font-semibold">
                {{ auth()->user()->name ?? 'Admin' }}
            </p>

        </div>

    </div>

</div>

<style>
@media print {

    .no-print {
        display: none;
    }

    body {
        background: white;
    }

}
</style>

@endsection