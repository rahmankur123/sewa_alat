@extends('layouts.app')

@section('title','Detail Transaksi Selesai')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Detail Transaksi Selesai
            </h2>
            <p class="text-sm text-gray-500">
                Informasi lengkap transaksi penyewaan
            </p>
        </div>

        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm w-fit">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow p-6 md:p-8 space-y-8">

        {{-- INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

            <div>
                <p class="text-gray-500 mb-1">Nama Penyewa</p>
                <p class="font-semibold text-gray-800">
                    {{ $transaksi->user->name }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 mb-1">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                    {{ ucfirst($transaksi->status_transaksi) }}
                </span>
            </div>

            <div>
                <p class="text-gray-500 mb-1">Tanggal Pinjam</p>
                <p class="text-gray-700">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 mb-1">Tanggal Kembali</p>
                <p class="text-gray-700">
                    {{ $transaksi->tanggal_kembali_real 
                        ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                        : '-' }}
                </p>
            </div>

        </div>

        {{-- BARANG --}}
        <div>
            <h3 class="font-semibold text-gray-800 mb-3">
                Barang Disewa
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="p-3 text-left">Barang</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 text-right">Harga / Hari</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $total_sewa = 0; @endphp

                    @foreach($transaksi->detail as $d)
                        @php $total_sewa += $d->subtotal; @endphp
                        <tr class="border-b last:border-0 hover:bg-gray-50 transition">

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

                    <tr class="bg-gray-50 font-semibold">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

            {{-- KETERLAMBATAN --}}
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">
                    Keterlambatan
                </h4>

                @forelse($transaksi->keterlambatan as $k)
                    <div class="flex justify-between py-1 border-b last:border-0">
                        <span>{{ $k->durasi_hari }} hari</span>
                        <span class="text-red-500">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- KERUSAKAN --}}
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">
                    Kerusakan
                </h4>

                @forelse($transaksi->kerusakan as $k)
                    <div class="flex justify-between py-1 border-b last:border-0">
                        <span>{{ $k->barang->nama_barang }} ({{ $k->qty }})</span>
                        <span class="text-red-500">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- KEHILANGAN --}}
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">
                    Kehilangan
                </h4>

                @forelse($transaksi->barangHilang as $h)
                    <div class="flex justify-between py-1 border-b last:border-0">
                        <span>{{ $h->barang->nama_barang }} ({{ $h->qty }})</span>
                        <span class="text-red-500">
                            Rp {{ number_format($h->denda,0,',','.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400">Tidak ada</p>
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

        <div class="bg-gray-50 rounded-xl p-5 text-sm space-y-2 shadow-sm">

            <div class="flex justify-between">
                <span>Total Sewa</span>
                <span>
                    Rp {{ number_format($total_sewa,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Total Denda</span>
                <span class="text-red-500">
                    Rp {{ number_format($total_denda,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between font-bold text-lg border-t pt-2">
                <span>Total Bayar</span>
                <span class="text-gray-800">
                    Rp {{ number_format($grand_total,0,',','.') }}
                </span>
            </div>

        </div>

    </div>

</div>

@endsection