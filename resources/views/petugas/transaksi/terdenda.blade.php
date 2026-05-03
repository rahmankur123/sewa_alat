@extends('layouts.app')
@section('title','Transaksi Terdenda')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Terdenda
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
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama User</th>
                    <th class="px-6 py-3">Denda Kerusakan</th>
                    <th class="px-6 py-3">Denda Keterlambatan</th>
                    <th class="px-6 py-3">Total Denda</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)

                @php
                    $dendaKerusakan = $d->kerusakan->sum('total_denda');
                    $dendaTerlambat = $d->keterlambatan->sum('total_denda');
                    $totalDenda = $dendaKerusakan + $dendaTerlambat;
                @endphp

                <tr class="border-t hover:bg-slate-50 transition">

                    {{-- NOMOR --}}
                    <td class="px-6 py-4">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-4 font-medium">
                        {{ $d->user->name }}
                    </td>

                    {{-- DENDA KERUSAKAN --}}
                    <td class="px-6 py-4 text-red-500 font-medium">
                        Rp {{ number_format($dendaKerusakan,0,',','.') }}
                    </td>

                    {{-- DENDA KETERLAMBATAN --}}
                    <td class="px-6 py-4 text-orange-500 font-medium">
                        Rp {{ number_format($dendaTerlambat,0,',','.') }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="px-6 py-4 font-semibold text-slate-700">
                        Rp {{ number_format($totalDenda,0,',','.') }}
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4 text-center space-x-1">

                        {{-- LUNAS --}}
                        <form action="{{ route('petugas.transaksi.lunas',$d->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin transaksi ini sudah lunas?')">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1 text-xs bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                                Lunas
                            </button>
                        </form>

                        {{-- DETAIL --}}
                        <a href="{{ route('petugas.transaksi.detailDenda',$d->id) }}"
                           class="px-3 py-1 text-xs bg-slate-500 text-white rounded-md hover:bg-slate-600">
                           Detail
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-slate-400">
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