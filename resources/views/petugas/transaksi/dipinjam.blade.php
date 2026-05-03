@extends('layouts.app')
@section('title','Transaksi Dipinjam')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Dipinjam
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
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama User</th>
                    <th class="px-6 py-3 text-center">Tanggal Sewa</th>
                    <th class="px-6 py-3 text-center">Rencana Kembali</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)
                <tr class="border-t hover:bg-slate-50 transition">

                    {{-- NOMOR --}}
                    <td class="px-6 py-4">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-4 font-medium">
                        {{ $d->user->name }}
                    </td>

                    {{-- TANGGAL --}}
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4 text-center space-x-1">

                        {{-- HAPUS --}}
                        <form action="{{ route('petugas.transaksi.hapus',$d->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin mau hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600">
                                Hapus
                            </button>
                        </form>

                        {{-- DIKEMBALIKAN --}}
                        <a href="{{ route('petugas.transaksi.formKembalikan',$d->id) }}"
                           class="px-3 py-1 text-xs bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                           Dikembalikan
                        </a>

                        {{-- DETAIL --}}
                        <a href="{{ route('petugas.transaksi.detail', $d->id) }}"
                           class="px-3 py-1 text-xs bg-slate-500 text-white rounded-md hover:bg-slate-600">
                           Detail
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-400">
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