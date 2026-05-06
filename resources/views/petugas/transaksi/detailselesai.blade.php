@extends('layouts.app')

@section('title','Detail Transaksi Selesai')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Detail Transaksi Selesai
</h2>

<a href="{{ url()->previous() }}"
   class="inline-block mb-4 px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800">
    ← Kembali
</a>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-6">

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-4 text-sm">

        <div>
            <p class="text-slate-500">Nama Penyewa</p>
            <p class="font-semibold">{{ $transaksi->user->name }}</p>
        </div>

        <div>
            <p class="text-slate-500">Status</p>
            <p class="font-semibold capitalize">{{ $transaksi->status_transaksi }}</p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Kembali</p>
            <p>
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- BARANG --}}
    <div>
        <h3 class="font-semibold text-slate-700 mb-3">Barang Disewa</h3>

        <table class="w-full text-sm border">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-2 border text-left">Barang</th>
                    <th class="p-2 border text-center">Qty</th>
                    <th class="p-2 border text-right">Harga/Hari</th>
                    <th class="p-2 border text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>

            @php $total_sewa = 0; @endphp

            @foreach($transaksi->detail as $d)
                @php
                    $total_sewa += $d->subtotal;
                @endphp
                <tr>
                    <td class="p-2 border">{{ $d->barang->nama_barang }}</td>
                    <td class="p-2 border text-center">{{ $d->qty }}</td>
                    <td class="p-2 border text-right">
                        Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                    </td>
                    <td class="p-2 border text-right">
                        Rp {{ number_format($d->subtotal,0,',','.') }}
                    </td>
                </tr>
            @endforeach

            <tr class="bg-slate-50 font-semibold">
                <td colspan="3" class="p-2 border text-right">Total Sewa</td>
                <td class="p-2 border text-right">
                    Rp {{ number_format($total_sewa,0,',','.') }}
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    {{-- DENDA --}}
    <div class="grid grid-cols-3 gap-6 text-sm">

        {{-- KETERLAMBATAN --}}
        <div>
            <h4 class="font-semibold mb-2 text-slate-700">Keterlambatan</h4>

            @forelse($transaksi->keterlambatan as $k)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $k->durasi_hari }} hari</span>
                    <span class="text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400">Tidak ada</p>
            @endforelse
        </div>

        {{-- KERUSAKAN --}}
        <div>
            <h4 class="font-semibold mb-2 text-slate-700">Kerusakan</h4>

            @forelse($transaksi->kerusakan as $k)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $k->barang->nama_barang }} ({{ $k->qty }})</span>
                    <span class="text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400">Tidak ada</p>
            @endforelse
        </div>

        {{-- KEHILANGAN --}}
        <div>
            <h4 class="font-semibold mb-2 text-slate-700">Kehilangan</h4>

            @forelse($transaksi->barangHilang as $h)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $h->barang->nama_barang }} ({{ $h->qty }})</span>
                    <span class="text-red-500">
                        Rp {{ number_format($h->denda,0,',','.') }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400">Tidak ada</p>
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

    <div class="bg-slate-50 border rounded-lg p-4 text-sm space-y-2">

        <div class="flex justify-between">
            <span>Total Sewa</span>
            <span>Rp {{ number_format($total_sewa,0,',','.') }}</span>
        </div>

        <div class="flex justify-between">
            <span>Total Denda</span>
            <span class="text-red-500">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-lg border-t pt-2">
            <span>Total Bayar</span>
            <span>
                Rp {{ number_format($grand_total,0,',','.') }}
            </span>
        </div>

    </div>

</div>

@endsection