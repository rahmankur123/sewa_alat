@extends('layouts.app')
@section('title','Transaksi Terdenda')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Transaksi Terdenda
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
                    <th class="px-6 py-3 text-left w-40">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-right w-40">Total Denda Keterlambatan</th>
                    <th class="px-6 py-3 text-right w-32">Total Denda Kerusakan</th>
                    <th class="px-6 py-3 text-right w-40">Total Denda</th>
                    <th class="px-6 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody>

            @forelse($data as $d)

                @php
                    $total_denda =
                        $d->kerusakan->sum('total_denda') +
                        $d->keterlambatan->sum('total_denda');
                @endphp

                <tr class="border-t hover:bg-red-50 transition duration-150">

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
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_real)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4 text-right">
                        @php
                        $denda_keterlambatan = $d->keterlambatan->sum('total_denda');
                    @endphp
                    @if($denda_keterlambatan > 0)
                        <span class="text-red-500">
                            Rp {{ number_format($denda_keterlambatan, 0, ',', '.') }}
                        </span>
                    @else
                        Rp 0
                    @endif
                    </td>


                    <td class="px-6 py-4 text-right">
                        @php
                        $denda_kerusakan = $d->kerusakan->sum('total_denda');
                    @endphp
                    @if($denda_kerusakan > 0)
                        <span class="text-red-500">
                            Rp {{ number_format($denda_kerusakan, 0, ',', '.') }}
                        </span>
                    @else
                        Rp 0
                    @endif

                    </td>

                    <td class="px-6 py-4 text-right">
                        <span class="text-red-500 font-semibold">
                            Rp {{ number_format($total_denda,0,',','.') }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('anggota.riwayat.detaildenda', $d->id) }}"
                           class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                           Detail Denda
                        </a>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-slate-400">
                        Tidak ada transaksi terdenda
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection