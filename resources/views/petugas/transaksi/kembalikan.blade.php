@extends('layouts.app')
@section('title','Pengembalian Barang')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Pengembalian Barang
</h2>

{{-- KEMBALI --}}
<a href="{{ url()->previous() }}"
   class="inline-flex items-center gap-2 mb-4 px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition">
    ← Kembali
</a>

<form method="POST"
action="{{ route('petugas.transaksi.prosesKembalikan',$transaksi->id) }}">

@csrf

{{-- CARD UTAMA --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-6">

    {{-- INFO TRANSAKSI --}}
    <div class="grid grid-cols-2 gap-4 text-sm">

        <div>
            <p class="text-slate-500">Nama Penyewa</p>
            <p class="font-semibold text-slate-700">
                {{ $transaksi->user->name }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p class="text-slate-700">
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Kembali Rencana</p>
            <p class="text-slate-700">
                {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- INPUT TANGGAL --}}
    <div>
        <label class="block text-sm text-slate-600 mb-1">
            Tanggal Kembali
        </label>

        <input type="date"
            name="tanggal_kembali_real"
            required
            class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-400 outline-none">
    </div>

    {{-- KERUSAKAN --}}
    <div>
        <h3 class="font-semibold text-slate-700 mb-4">
            Kerusakan Barang
        </h3>

        <div class="space-y-4">

            @forelse($transaksi->detail as $item)

            <div class="border rounded-lg p-4">

                {{-- NAMA BARANG --}}
                <div class="flex justify-between items-center mb-2">
                    <p class="font-medium text-slate-700">
                        {{ $item->barang->nama_barang }}
                    </p>

                    <span class="text-sm text-slate-500">
                        Qty: {{ $item->qty }}
                    </span>
                </div>

                {{-- CHECKBOX --}}
                <div class="flex flex-wrap gap-3 mt-2">

                    @for($i=1;$i<=$item->qty;$i++)
                        <label class="flex items-center gap-2 text-sm bg-slate-100 px-3 py-1 rounded cursor-pointer hover:bg-slate-200">
                            
                            <input type="checkbox"
                                name="rusak[{{ $item->barang_id }}][]"
                                value="1"
                                class="accent-red-500">

                            Unit {{ $i }}
                        </label>
                    @endfor

                </div>

            </div>

            @empty
            <p class="text-slate-400 text-sm">
                Tidak ada data barang
            </p>
            @endforelse

        </div>
    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end">
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Simpan Pengembalian
        </button>
    </div>

</div>

</form>

@endsection