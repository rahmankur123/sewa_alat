@extends('layouts.app')
@section('title','Pengembalian Barang')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h2 class="text-3xl font-bold tracking-tight text-slate-800">
                Pengembalian Barang
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Proses pengembalian dan pencatatan kerusakan / kehilangan barang
            </p>

        </div>

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center text-white gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 cursor-pointer transition">

            ← Kembali

        </a>

    </div>

    {{-- ALERT --}}
    @if(session('error'))
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST"
          action="{{ route('petugas.transaksi.prosesKembalikan', $transaksi->id) }}">

        @csrf

        <div class="space-y-6">

            {{-- INFO TRANSAKSI --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm">

                <div class="flex items-center justify-between mb-6">

                    <div>

                        <h3 class="text-lg font-semibold text-slate-800">
                            Informasi Transaksi
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail data penyewaan pelanggan
                        </p>

                    </div>

                    <div class="hidden md:flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                        📋
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <div class="rounded-2xl bg-slate-50 p-5">

                        <p class="text-xs uppercase tracking-wide text-slate-400 mb-2">
                            Nama Penyewa
                        </p>

                        <p class="font-semibold text-slate-800">
                            {{ $transaksi->user->name }}
                        </p>

                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">

                        <p class="text-xs uppercase tracking-wide text-slate-400 mb-2">
                            Tanggal Pinjam
                        </p>

                        <p class="font-medium text-slate-700">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </p>

                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">

                        <p class="text-xs uppercase tracking-wide text-slate-400 mb-2">
                            Rencana Kembali
                        </p>

                        <p class="font-medium text-slate-700">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- TANGGAL KEMBALI --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Tanggal Kembali
                </label>

                <input type="date"
                       name="tanggal_kembali_real"
                       value="{{ old('tanggal_kembali_real', date('Y-m-d')) }}"
                       required
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition">

            </div>

            {{-- KERUSAKAN --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm">

                <div class="mb-6">

                    <h3 class="text-lg font-semibold text-slate-800">
                        Kerusakan Barang
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Tandai kondisi setiap unit barang yang dikembalikan
                    </p>

                </div>

                <div class="space-y-5">

                    @forelse($transaksi->detail as $item)

                    <div class="rounded-3xl border border-slate-200 bg-slate-50/70 p-5">

                        {{-- HEADER --}}
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                            <div>

                                <h4 class="font-semibold text-slate-800">
                                    {{ $item->barang->nama_barang }}
                                </h4>

                                <p class="text-sm text-slate-500 mt-1">
                                    Qty Dipinjam: {{ $item->qty }}
                                </p>

                            </div>

                            <div class="flex gap-3">

                                <div class="rounded-2xl bg-orange-50 border border-orange-100 px-4 py-3 text-sm">
                                    <p class="text-orange-500 text-xs mb-1">
                                        Ringan
                                    </p>

                                    <p class="font-semibold text-orange-600">
                                        Rp {{ number_format($item->barang->denda_kerusakan ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-red-50 border border-red-100 px-4 py-3 text-sm">
                                    <p class="text-red-500 text-xs mb-1">
                                        Berat
                                    </p>

                                    <p class="font-semibold text-red-600">
                                        Rp {{ number_format($item->barang->denda_hilang ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- UNIT --}}
                        <div class="space-y-3">

                            @for($i = 1; $i <= $item->qty; $i++)

                            <div class="flex flex-col md:flex-row md:items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4">

                                <div class="md:w-28">

                                    <span class="inline-flex items-center rounded-xl bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700">
                                        Unit {{ $i }}
                                    </span>

                                </div>

                                <select
                                    name="rusak[{{ $item->barang_id }}][]"
                                    class="flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-red-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-red-100 transition"
                                >

                                    <option value="">Tidak Rusak</option>

                                    <option value="ringan"
                                        {{ old("rusak.$item->barang_id." . ($i-1)) == 'ringan' ? 'selected' : '' }}>
                                        Kerusakan Ringan
                                    </option>

                                    <option value="berat"
                                        {{ old("rusak.$item->barang_id." . ($i-1)) == 'berat' ? 'selected' : '' }}>
                                        Kerusakan Berat
                                    </option>

                                </select>

                            </div>

                            @endfor

                        </div>

                    </div>

                    @empty

                    <div class="rounded-2xl bg-slate-50 py-10 text-center text-sm text-slate-400">
                        Tidak ada data barang
                    </div>

                    @endforelse

                </div>

            </div>

            {{-- BARANG HILANG --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm">

                <div class="mb-6">

                    <h3 class="text-lg font-semibold text-slate-800">
                        Barang Hilang
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Input jumlah barang yang hilang dari penyewaan
                    </p>

                </div>

                <div class="space-y-5">

                    @forelse($transaksi->detail as $item)

                    @php
                        $hargaHilang = $item->barang->denda_hilang ?? 0;
                    @endphp

                    <div class="rounded-3xl border border-slate-200 bg-slate-50/70 p-5">

                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">

                            <div>

                                <h4 class="font-semibold text-slate-800">
                                    {{ $item->barang->nama_barang }}
                                </h4>

                                <p class="text-sm text-slate-500 mt-1">
                                    Qty Dipinjam: {{ $item->qty }}
                                </p>

                            </div>

                            <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm">

                                <p class="text-xs text-red-500 mb-1">
                                    Denda per unit
                                </p>

                                <p class="font-semibold text-red-600">
                                    Rp {{ number_format($hargaHilang, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                        <input type="number"
                               name="hilang[{{ $item->barang_id }}]"
                               min="0"
                               max="{{ $item->qty }}"
                               value="0"
                               data-qty="{{ $item->qty }}"
                               data-barang="{{ $item->barang_id }}"
                               class="input-hilang w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-red-400 focus:outline-none focus:ring-4 focus:ring-red-100 transition">

                        <p class="mt-2 text-xs text-slate-400">
                            Maksimal <span class="max-hilang">{{ $item->qty }}</span> unit.
                            Sistem otomatis menghitung batas sebenarnya:
                            Qty Dipinjam - Qty Rusak
                        </p>

                    </div>

                    @empty

                    <div class="rounded-2xl bg-slate-50 py-10 text-center text-sm text-slate-400">
                        Tidak ada data barang
                    </div>

                    @endforelse

                </div>

            </div>

            {{-- INFORMASI --}}
            <div class="rounded-3xl border border-blue-200 bg-blue-50 p-6 shadow-sm">

                <div class="flex items-start gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                        ℹ️
                    </div>

                    <div>

                        <h3 class="font-semibold text-blue-800 mb-3">
                            Aturan Perhitungan Denda
                        </h3>

                        <ul class="space-y-2 text-sm text-blue-700">

                            <li>• Kerusakan Ringan menggunakan <strong>harga_kerusakan</strong>.</li>

                            <li>• Kerusakan Berat menggunakan <strong>harga barang penuh</strong>.</li>

                            <li>• Barang Hilang menggunakan <strong>harga barang × jumlah hilang</strong>.</li>

                            <li>• Jumlah barang hilang tidak boleh melebihi sisa unit setelah dikurangi barang rusak.</li>

                            <li>• Jika ada denda atau keterlambatan, status transaksi otomatis menjadi <strong>terdenda</strong>.</li>

                        </ul>

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end">

                <button type="submit"
                        class="rounded-2xl cursor-pointer bg-indigo-600 px-7 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 hover:shadow-md transition">

                    Simpan Pengembalian

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

{{-- SCRIPT VALIDASI OTOMATIS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    function hitungBatasHilang() {

        document.querySelectorAll('.input-hilang').forEach(function(inputHilang) {

            const barangId = inputHilang.dataset.barang;
            const qtyPinjam = parseInt(inputHilang.dataset.qty) || 0;

            let qtyRusak = 0;

            document.querySelectorAll(`select[name^="rusak[${barangId}]"]`).forEach(function(select) {

                if (select.value !== '') {
                    qtyRusak++;
                }

            });

            let maxHilang = qtyPinjam - qtyRusak;

            if (maxHilang < 0) {
                maxHilang = 0;
            }

            inputHilang.max = maxHilang;

            let nilai = parseInt(inputHilang.value) || 0;

            if (nilai > maxHilang) {
                inputHilang.value = maxHilang;
            }

            const info = inputHilang.closest('.rounded-3xl')
                                   .querySelector('.max-hilang');

            if (info) {
                info.textContent = maxHilang;
            }

            if (maxHilang <= 0) {

                inputHilang.value = 0;
                inputHilang.readOnly = true;

                inputHilang.classList.add('bg-slate-100', 'cursor-not-allowed');

            } else {

                inputHilang.readOnly = false;

                inputHilang.classList.remove('bg-slate-100', 'cursor-not-allowed');

            }

        });

    }

    document.querySelectorAll('select[name^="rusak["]').forEach(function(select) {

        select.addEventListener('change', hitungBatasHilang);

    });

    document.querySelectorAll('.input-hilang').forEach(function(input) {

        input.addEventListener('input', function() {

            let max = parseInt(this.max) || 0;
            let val = parseInt(this.value) || 0;

            if (val > max) {
                this.value = max;
            }

            if (val < 0) {
                this.value = 0;
            }

        });

    });

    hitungBatasHilang();

});
</script>