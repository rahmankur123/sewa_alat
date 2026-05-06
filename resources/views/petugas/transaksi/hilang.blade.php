@extends('layouts.app')
@section('title','Data Barang Hilang')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Data Barang Hilang
            </h2>
            <p class="text-sm text-gray-500">
                Daftar barang yang hilang dalam transaksi
            </p>
        </div>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Penyewa</th>
                        <th class="px-6 py-3 text-left">Barang</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Denda</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($data as $item)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- NOMOR --}}
                        <td class="px-6 py-4">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        {{-- PENYEWA --}}
                        <td class="px-6 py-4 font-medium text-gray-700">
                            {{ $item->transaksi->user->name }}
                        </td>

                        {{-- BARANG --}}
                        <td class="px-6 py-4">
                            {{ $item->barang->nama_barang }}
                        </td>

                        {{-- QTY --}}
                        <td class="px-6 py-4 text-center">
                            {{ $item->qty }}
                        </td>

                        {{-- DENDA --}}
                        <td class="px-6 py-4 text-right font-semibold text-red-500">
                            Rp {{ number_format($item->denda,0,',','.') }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-gray-500">
                            {{ $item->created_at->format('d M Y') }}
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">
                            Tidak ada data barang hilang
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