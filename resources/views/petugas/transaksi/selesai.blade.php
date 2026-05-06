@extends('layouts.app')
@section('title','Transaksi Selesai')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Selesai
</h2>

{{-- NOTIF --}}
@if(session('success'))
<div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
    {{ session('error') }}
</div>
@endif

{{-- SEARCH --}}
<div class="mb-4 flex justify-between items-center">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama user..."
            class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
        
        <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-700">
            Cari
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left w-12">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Tgl Sewa</th>
                    <th class="px-4 py-3 text-left">Tgl Kembali</th>
                    <th class="px-4 py-3 text-right">Total Sewa</th>
                    <th class="px-4 py-3 text-right">Denda Telat</th>
                    <th class="px-4 py-3 text-right">Denda Rusak</th>
                    <th class="px-4 py-3 text-right">Denda Hilang</th>
                    <th class="px-4 py-3 text-right">Total Bayar</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)

                @php
                    $denda_keterlambatan = $d->keterlambatan->sum('total_denda');
                    $denda_kerusakan = $d->kerusakan->sum('total_denda');
                    $denda_hilang = $d->barangHilang->sum('denda');

                    $total_denda = $denda_keterlambatan + $denda_kerusakan + $denda_hilang;
                    $total_bayar = $d->total_harga + $total_denda;
                @endphp

                <tr class="border-t hover:bg-slate-50 transition">

                    {{-- NO --}}
                    <td class="px-4 py-3">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-4 py-3 font-medium text-slate-700">
                        {{ $d->user->name }}
                    </td>

                    {{-- TGL --}}
                    <td class="px-4 py-3 text-slate-600">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-4 py-3 text-slate-600">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_real)->translatedFormat('d F Y') }}
                    </td>

                    {{-- TOTAL SEWA --}}
                    <td class="px-4 py-3 text-right font-semibold">
                        Rp {{ number_format($d->total_harga,0,',','.') }}
                    </td>

                    {{-- DENDA TELAT --}}
                    <td class="px-4 py-3 text-right">
                        @if($denda_keterlambatan > 0)
                            <span class="text-red-500 font-medium">
                                Rp {{ number_format($denda_keterlambatan,0,',','.') }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>

                    {{-- DENDA RUSAK --}}
                    <td class="px-4 py-3 text-right">
                        @if($denda_kerusakan > 0)
                            <span class="text-red-500 font-medium">
                                Rp {{ number_format($denda_kerusakan,0,',','.') }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>

                    {{-- DENDA HILANG --}}
                    <td class="px-4 py-3 text-right">
                        @if($denda_hilang > 0)
                            <span class="text-red-500 font-medium">
                                Rp {{ number_format($denda_hilang,0,',','.') }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>

                    {{-- TOTAL BAYAR --}}
                    <td class="px-4 py-3 text-right font-bold text-slate-800">
                        Rp {{ number_format($total_bayar,0,',','.') }}
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-center space-x-1">

                        <form action="{{ route('petugas.transaksi.hapus',$d->id) }}" method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin mau hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600">
                                Hapus
                            </button>
                        </form>

                        <a href="{{ route('petugas.transaksi.detailSelesai', $d->id) }}"
                           class="px-3 py-1 text-xs bg-slate-600 text-white rounded-md hover:bg-slate-700">
                           Detail
                        </a>

                        <a href="{{ route('petugas.transaksi.notaSelesai',$d->id) }}"
                           class="px-3 py-1 text-xs bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                           Nota
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center py-10 text-slate-400">
                        Data tidak ada
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

@endsection