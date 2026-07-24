@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Detail Transaksi
            </h2>
            <p class="text-sm text-gray-500">
                Informasi lengkap transaksi penyewaan
            </p>
        </div>

        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer text-sm w-fit">
            ← Kembali
        </a>
    </div>

    {{-- INFO CARD --}}
    <div class="bg-white rounded-2xl shadow p-5 md:p-6 mb-6">

        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 text-sm">

            <div>
                <p class="text-gray-400">No Transaksi</p>
                <p class="font-semibold text-gray-800">
                    #{{ $transaksi->id }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Nama User</p>
                <p class="font-semibold text-gray-800">
                    {{ $transaksi->user->name }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Status</p>
                <span class="inline-block px-3 py-1 text-xs rounded-full font-medium
                    {{ $transaksi->status_transaksi == 'selesai' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $transaksi->status_transaksi == 'dipinjam' ? 'bg-yellow-100 text-yellow-600' : '' }}
                    {{ $transaksi->status_transaksi == 'terlambat' ? 'bg-red-100 text-red-600' : '' }}">
                    {{ ucfirst($transaksi->status_transaksi) }}
                </span>
            </div>

            <div>
                <p class="text-gray-400">Tanggal Pinjam</p>
                <p>
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Rencana Kembali</p>
                <p>
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Kembali Real</p>
                <p>
                    {{ $transaksi->tanggal_kembali_real 
                        ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                        : '-' }}
                </p>
            </div>

        </div>

        {{-- TOTAL HIGHLIGHT --}}
        <div class="mt-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div class="bg-gray-50 px-4 py-3 rounded-xl">
                <p class="text-xs text-gray-500">Total Harga</p>
                <p class="text-lg font-semibold text-indigo-600">
                    Rp {{ number_format($transaksi->total_harga,0,',','.') }}
                </p>
            </div>

            <div class="bg-gray-50 px-4 py-3 rounded-xl">
                <p class="text-xs text-gray-500">Total Item</p>
                <p class="font-semibold text-gray-800">
                    {{ $transaksi->detail->sum('qty') }} item
                </p>
            </div>

        </div>

    </div>


    {{-- DETAIL BARANG --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="px-5 py-4">
            <h3 class="font-semibold text-gray-800">
                Detail Barang
            </h3>
        </div>

        {{-- MOBILE VIEW --}}
        <div class="block md:hidden space-y-3 p-4">

            @foreach($transaksi->detail as $d)
            <div class="bg-gray-50 p-3 rounded-xl text-sm">

                <p class="font-semibold text-gray-800">
                    {{ $d->barang->nama_barang }}
                </p>

                <div class="flex justify-between text-xs mt-1 text-gray-500">
                    <span>Qty: {{ $d->qty }}</span>
                    <span>Rp {{ number_format($d->harga_per_hari,0,',','.') }}</span>
                </div>

                <div class="text-right font-semibold text-indigo-600 mt-2">
                    Rp {{ number_format($d->subtotal,0,',','.') }}
                </div>

            </div>
            @endforeach

        </div>


        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Barang</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Harga</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @php $total = 0; @endphp

                    @foreach($transaksi->detail as $d)
                    @php $total += $d->subtotal; @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            {{ $d->barang->nama_barang }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $d->qty }}
                        </td>

                        <td class="px-6 py-4 text-right text-gray-500">
                            Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-gray-800">
                            Rp {{ number_format($d->subtotal,0,',','.') }}
                        </td>
                    </tr>
                    @endforeach

                </tbody>

                <tfoot>
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="3" class="px-6 py-3 text-right">
                            Total
                        </td>
                        <td class="px-6 py-3 text-right text-indigo-600">
                            Rp {{ number_format($total,0,',','.') }}
                        </td>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection