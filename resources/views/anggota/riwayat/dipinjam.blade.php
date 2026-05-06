@extends('layouts.app')
@section('title','Transaksi Dipinjam')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Transaksi Dipinjam
        </h2>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama User</th>
                        <th class="px-6 py-3 text-left w-40">Tanggal Sewa</th>
                        <th class="px-6 py-3 text-left w-40">Rencana Kembali</th>
                        <th class="px-6 py-3 text-center w-32">Total</th>
                        <th class="px-6 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse($data as $d)

                    <tr class="border-t hover:bg-slate-50 transition">

                        {{-- NOMOR --}}
                        <td class="px-6 py-4 font-medium">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-4">
                            {{ $d->user->name }}
                        </td>

                        {{-- TANGGAL PINJAM --}}
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </td>

                        {{-- TANGGAL KEMBALI --}}
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="px-6 py-4 text-center font-semibold text-slate-700">
                            Rp {{ number_format($d->total_harga,0,',','.') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('anggota.riwayat.detail', $d->id) }}"
                               class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                Detail
                            </a>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-slate-400">
                            Tidak ada transaksi yang sedang dipinjam
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection