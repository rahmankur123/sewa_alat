@extends('layouts.app')

@section('title','Nota Denda')

@section('content')

{{-- BUTTON --}}
<div class="mb-4 flex justify-between items-center max-w-4xl mx-auto">

    <a href="{{ url()->previous() }}"
       class="px-4 py-2 bg-blue-600 cursor-pointer text-white rounded-lg hover:bg-blue-700 transition">
        ← Kembali
    </a>

    <button onclick="window.print()"
        class="px-4 py-2 cursor-pointer bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
        🖨️ Cetak Nota
    </button>

</div>

{{-- NOTA --}}
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow border border-slate-200 p-6 md:p-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-start border-b border-slate-200 pb-5 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Nota Denda
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Sistem Persewaan Alat Bela Diri
            </p>
        </div>

        <div class="text-right text-sm">
            <p class="text-slate-500">No Nota</p>

            <p class="font-semibold text-slate-800">
                INV-DENDA-{{ date('Ymd') }}-{{ $transaksi->id }}
            </p>

            <p class="text-slate-400">
                {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm mb-8">

        <div>
            <p class="text-slate-500 mb-1">Nama Penyewa</p>

            <p class="font-semibold text-slate-800">
                {{ $transaksi->user->name }}
            </p>
        </div>

        <div>
            <p class="text-slate-500 mb-1">Status</p>

            <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-semibold capitalize">
                {{ $transaksi->status_transaksi }}
            </span>
        </div>

        <div>
            <p class="text-slate-500 mb-1">Tanggal Pinjam</p>

            <p class="text-slate-700">
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-slate-500 mb-1">Tanggal Kembali</p>

            <p class="text-slate-700">
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- HITUNG TOTAL --}}
    @php
        $total_keterlambatan = $transaksi->keterlambatan->sum('total_denda');
        $total_kerusakan     = $transaksi->kerusakan->sum('total_denda');
        $total_hilang        = $transaksi->barangHilang->sum('denda');

        $total_denda = $total_keterlambatan + $total_kerusakan + $total_hilang;
    @endphp


    {{-- KETERLAMBATAN --}}
    <div class="mb-8">

        <h3 class="font-semibold text-slate-800 mb-3">
            Denda Keterlambatan
        </h3>

        @if($transaksi->keterlambatan->count())

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200">

                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left border-b">Durasi</th>
                        <th class="p-3 text-right border-b">Total Denda</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi->keterlambatan as $k)
                    <tr class="border-b last:border-0">

                        <td class="p-3">
                            {{ $k->durasi_hari }} Hari
                        </td>

                        <td class="p-3 text-right text-red-500 font-medium">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @else

        <p class="text-sm text-slate-400">
            Tidak ada keterlambatan
        </p>

        @endif

    </div>


    {{-- KERUSAKAN --}}
    <div class="mb-8">

        <h3 class="font-semibold text-slate-800 mb-3">
            Denda Kerusakan
        </h3>

        @if($transaksi->kerusakan->count())

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200">

                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left border-b">Barang</th>
                        <th class="p-3 text-center border-b">Qty</th>
                        <th class="p-3 text-center border-b">Jenis</th>
                        <th class="p-3 text-right border-b">Total Denda</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi->kerusakan as $k)
                    <tr class="border-b last:border-0">

                        <td class="p-3">
                            {{ $k->barang->nama_barang }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $k->qty }}
                        </td>

                        <td class="p-3 text-center capitalize">
                            {{ $k->jenis_kerusakan }}
                        </td>

                        <td class="p-3 text-right text-red-500 font-medium">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @else

        <p class="text-sm text-slate-400">
            Tidak ada kerusakan
        </p>

        @endif

    </div>


    {{-- BARANG HILANG --}}
    <div class="mb-8">

        <h3 class="font-semibold text-slate-800 mb-3">
            Barang Hilang
        </h3>

        @if($transaksi->barangHilang->count())

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200">

                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left border-b">Barang</th>
                        <th class="p-3 text-center border-b">Qty</th>
                        <th class="p-3 text-right border-b">Total Denda</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi->barangHilang as $h)
                    <tr class="border-b last:border-0">

                        <td class="p-3">
                            {{ $h->barang->nama_barang }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $h->qty }}
                        </td>

                        <td class="p-3 text-right text-red-500 font-medium">
                            Rp {{ number_format($h->denda,0,',','.') }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @else

        <p class="text-sm text-slate-400">
            Tidak ada barang hilang
        </p>

        @endif

    </div>


    {{-- TOTAL --}}
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

        <div class="space-y-2 text-sm">

            <div class="flex justify-between">
                <span class="text-slate-600">
                    Denda Keterlambatan
                </span>

                <span class="text-red-500 font-medium">
                    Rp {{ number_format($total_keterlambatan,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-600">
                    Denda Kerusakan
                </span>

                <span class="text-red-500 font-medium">
                    Rp {{ number_format($total_kerusakan,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-600">
                    Denda Barang Hilang
                </span>

                <span class="text-red-500 font-medium">
                    Rp {{ number_format($total_hilang,0,',','.') }}
                </span>
            </div>

        </div>

        <div class="border-t border-slate-200 mt-4 pt-4 flex justify-between items-center">

            <span class="text-lg font-bold text-slate-800">
                Total Denda
            </span>

            <span class="text-2xl font-bold text-red-600">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>

        </div>

    </div>


    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between items-end text-sm">

        <div>
            <p class="text-slate-500">
                Catatan:
            </p>

            <p class="text-slate-400">
                Harap segera melakukan pembayaran denda.
            </p>
        </div>

        <div class="text-center">
            <p class="text-slate-600 mb-16">
                Petugas
            </p>

            <p class="border-t border-slate-400 pt-1 px-6 inline-block font-medium text-slate-700">
                {{ auth()->user()->name ?? 'Admin' }}
            </p>
        </div>

    </div>

</div>

@endsection