@extends('layouts.app')
@section('title','Transaksi Tersewa')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Tersewa
</h2>

{{-- NOTIF --}}
@if(session('success'))
<div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
    {{ session('success') }}
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
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Tanggal Sewa</th>
                    <th class="px-6 py-3 text-center">Kembali</th>
                    <th class="px-6 py-3 text-center">Total</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)
                <tr class="border-t hover:bg-slate-50">

                    <td class="px-6 py-4">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $d->user->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4 font-semibold">
                        Rp {{ number_format($d->total_harga,0,',','.') }}
                    </td>

                    <td class="px-6 py-4 text-center space-x-1">

                        {{-- HAPUS --}}
                        <form action="{{ route('petugas.transaksi.hapus',$d->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin mau hapus data ini?')">
                            @csrf
                            <button class="px-3 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600">
                                Hapus
                            </button>
                        </form>

                        {{-- DIAMBIL --}}
                        <form action="{{ route('petugas.transaksi.diambil',$d->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="px-3 py-1 text-xs bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                                Diambil
                            </button>
                        </form>

                        {{-- DETAIL --}}
                        <a href="{{ route('petugas.transaksi.detail', $d->id) }}"
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