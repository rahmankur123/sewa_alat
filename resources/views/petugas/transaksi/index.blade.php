@extends('layouts.app')

@section('title','Data Transaksi')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">
                Data Transaksi
            </h1>
            <p class="text-sm text-gray-500">
                Daftar semua transaksi penyewaan
            </p>
        </div>

        <a href="{{ route('petugas.transaksi.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition w-fit">
            + Transaksi Baru
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Anggota</th>
                        <th class="px-6 py-3 text-left">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-right">Total</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                @forelse($transaksi as $t)
                <tr class="hover:bg-gray-50 transition">

                    {{-- ID --}}
                    <td class="px-6 py-4">
                        #{{ $t->id }}
                    </td>

                    {{-- USER --}}
                    <td class="px-6 py-4 font-medium text-gray-700">
                        {{ $t->user->name ?? '-' }}
                    </td>

                    {{-- TANGGAL --}}
                    <td class="px-6 py-4 text-gray-500">
                        {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d M Y') }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="px-6 py-4 text-right font-semibold text-indigo-600">
                        Rp {{ number_format($t->total_harga,0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $t->status_transaksi == 'dipinjam' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $t->status_transaksi == 'selesai' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $t->status_transaksi == 'terlambat' ? 'bg-red-100 text-red-600' : '' }}">
                            {{ ucfirst($t->status_transaksi) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4 text-center space-x-1">

                        <a href="{{ route('petugas.transaksi.show',$t->id) }}"
                           class="px-3 py-1 text-xs bg-slate-500 text-white rounded-md hover:bg-slate-600">
                            Detail
                        </a>

                        <a href="{{ route('petugas.transaksi.nota',$t->id) }}"
                           class="px-3 py-1 text-xs bg-gray-700 text-white rounded-md hover:bg-gray-800">
                            Nota
                        </a>

                        <button onclick="openReturnModal({{ $t->id }})"
                            class="px-3 py-1 text-xs bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                            Selesai
                        </button>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">
                        Tidak ada data transaksi
                    </td>
                </tr>
                @endforelse

                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $transaksi->links() }}
    </div>

</div>

@endsection