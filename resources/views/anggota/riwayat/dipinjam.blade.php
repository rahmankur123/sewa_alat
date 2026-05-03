@extends('layouts.app')
@section('title','Transaksi Dipinjam')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Dipinjam
</h2>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            {{-- HEADER --}}
            <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left w-16">NO</th>
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

                <tr class="border-t hover:bg-slate-100 transition duration-150">

                    <td class="px-6 py-4 font-medium">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $d->user->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4 text-center font-medium">
                        Rp {{ number_format($d->total_harga,0,',','.') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('anggota.riwayat.detail', $d->id) }}"
                           class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                           Detail
                        </a>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-400">
                        Tidak ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection