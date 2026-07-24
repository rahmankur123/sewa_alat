@extends('layouts.app')

@section('title','Nota Denda')

@section('content')

{{-- ACTION --}}
<div class="no-print mb-4 flex justify-between max-w-4xl mx-auto">

    <a href="{{ url()->previous() }}"
       class="px-4 py-2 text-white bg-blue-600 cursor-pointer rounded-lg hover:bg-blue-700">
        ← Kembali
    </a>

    <button onclick="window.print()"
        class="px-4 py-2 bg-indigo-600 text-white cursor-pointer rounded-lg hover:bg-indigo-700">
        🖨️ Cetak
    </button>

</div>

{{-- NOTA --}}
<div class="print-area max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-8">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Nota Denda
            </h2>
            <p class="text-sm text-gray-500">
                Sistem Persewaan Alat Bela Diri
            </p>
        </div>

        <div class="text-right text-sm">
            <p class="text-gray-500">No Nota</p>
            <p class="font-semibold text-gray-800">
                INV-{{ $transaksi->id }}-{{ date('Ymd') }}
            </p>
            <p class="text-gray-400">
                {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-4 text-sm mb-8">

        <div>
            <p class="text-gray-400">Nama</p>
            <p class="font-medium">{{ $transaksi->user->name }}</p>
        </div>

        <div>
            <p class="text-gray-400">Status</p>
            <p class="capitalize font-medium">
                {{ $transaksi->status_transaksi }}
            </p>
        </div>

        <div>
            <p class="text-gray-400">Tanggal Pinjam</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-gray-400">Tanggal Kembali</p>
            <p>
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- SECTION FUNCTION --}}
    @php
        $total_keterlambatan = $transaksi->keterlambatan->sum('total_denda');
        $total_kerusakan = $transaksi->kerusakan->sum('total_denda');
        $total_hilang = $transaksi->barangHilang->sum('denda');
        $total_denda = $total_keterlambatan + $total_kerusakan + $total_hilang;
    @endphp

    {{-- KETERLAMBATAN --}}
    @if($transaksi->keterlambatan->count())
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">
            Denda Keterlambatan
        </h3>

        <div class="bg-gray-50 rounded-lg p-3 space-y-2 text-sm">
            @foreach($transaksi->keterlambatan as $k)
            <div class="flex justify-between">
                <span>{{ $k->durasi_hari }} hari</span>
                <span class="text-red-500">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- KERUSAKAN --}}
    @if($transaksi->kerusakan->count())
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">
            Denda Kerusakan
        </h3>

        <div class="bg-gray-50 rounded-lg p-3 space-y-2 text-sm">
            @foreach($transaksi->kerusakan as $k)
            <div class="flex justify-between">
                <span>{{ $k->barang->nama_barang }} ({{ $k->qty }} {{ $k->jenis_kerusakan }})</span>
                <span class="text-red-500">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- HILANG --}}
    @if($transaksi->barangHilang->count())
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">
            Barang Hilang
        </h3>

        <div class="bg-gray-50 rounded-lg p-3 space-y-2 text-sm">
            @foreach($transaksi->barangHilang as $h)
            <div class="flex justify-between">
                <span>{{ $h->barang->nama_barang }} ({{ $h->qty }})</span>
                <span class="text-red-500">
                    Rp {{ number_format($h->denda,0,',','.') }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- TOTAL --}}
    <div class="bg-gray-100 rounded-xl p-4 mt-6">

        <div class="flex justify-between text-sm mb-1">
            <span>Keterlambatan</span>
            <span class="text-red-500">Rp {{ number_format($total_keterlambatan,0,',','.') }}</span>
        </div>

        <div class="flex justify-between text-sm mb-1">
            <span>Kerusakan</span>
            <span class="text-red-500">Rp {{ number_format($total_kerusakan,0,',','.') }}</span>
        </div>

        <div class="flex justify-between text-sm mb-2">
            <span>Barang Hilang</span>
            <span class="text-red-500">Rp {{ number_format($total_hilang,0,',','.') }}</span>
        </div>

        <div class="flex justify-between font-semibold text-lg border-t pt-2">
            <span>Total</span>
            <span class="text-red-600">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between text-sm">

        <div class="text-gray-500">
            Harap segera melakukan pembayaran
        </div>

        <div class="text-right">
            <p>Petugas</p>
            <br><br>
            <p class="font-medium">
                {{ auth()->user()->name ?? 'Admin' }}
            </p>
        </div>

    </div>

</div>

@endsection