<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyewaan</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .kop-wrapper{
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-table{
            width: 100%;
            border: none;
        }

        .kop-table td{
            border: none;
            vertical-align: middle;
        }

        .logo{
            width: 85px;
        }

        .judul{
            text-align: center;
        }

        .judul h1{
            margin: 0;
            font-size: 20px;
        }

        .judul h2{
            margin: 2px 0;
            font-size: 15px;
            font-weight: normal;
        }

        .judul p{
            margin: 2px 0;
            font-size: 11px;
        }

        .garis{
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .laporan-title{
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .filter{
            text-align: center;
            margin-bottom: 18px;
            font-size: 11px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        th{
            background: #f2f2f2;
        }

        .text-right{
            text-align: right;
        }

        .text-center{
            text-align: center;
        }

        .footer{
            margin-top: 40px;
            width: 100%;
        }

        .ttd{
            width: 250px;
            float: right;
            text-align: center;
        }

        .nama-ttd{
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    {{-- ================= KOP SURAT ================= --}}
    <div class="kop-wrapper">

        <table class="kop-table">
            <tr>

                {{-- LOGO --}}
                <td width="90">
                    <img src="{{ public_path('storage/logo.jpg') }}" class="logo">
                </td>

                {{-- IDENTITAS --}}
                <td class="judul">
                    <h1>PERSEWAAN ALAT BELA DIRI</h1>
                    <h2>BD CAMP JUJITSU & KICKBOXING</h2>

                    <p>
                        Sawah, Bulakrejo, Kec. Sukoharjo, Kab. Sukoharjo
                    </p>

                    <p>
                        Telp: 0823 3032 9833 | Email: blackdragger1@gmail.com
                    </p>

                </td>

            </tr>
        </table>

        <div class="garis"></div>

    </div>

    {{-- ================= JUDUL ================= --}}
    <div class="laporan-title">
        LAPORAN PENYEWAAN
    </div>

    {{-- ================= FILTER ================= --}}
    @if(request('tanggal_awal') || request('tanggal_akhir'))

        <div class="filter">

            @if(request('tanggal_awal') && request('tanggal_akhir'))

                Periode :
                {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}

            @elseif(request('tanggal_awal'))

                Dari Tanggal :
                {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}

            @elseif(request('tanggal_akhir'))

                Sampai Tanggal :
                {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}

            @endif

        </div>

    @endif

    {{-- ================= TABLE ================= --}}
    <table>

        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penyewa</th>
                <th>Barang</th>
                <th class="text-center">Qty</th>
                <th>Status</th>
                <th class="text-right">Total Sewa</th>
                <th class="text-right">Total Denda</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>

        <tbody>

            @php
                $grandSewa = 0;
                $grandDenda = 0;
                $grandBayar = 0;
            @endphp

            @forelse($data as $i => $t)

                @php
                    $totalSewa = $t->detail->sum(function ($d) {
                        return $d->subtotal;
                    });

                    $totalDenda =
                        ($t->kerusakan ? $t->kerusakan->sum('total_denda') : 0) +
                        ($t->keterlambatan ? $t->keterlambatan->sum('total_denda') : 0) +
                        ($t->barangHilang ? $t->barangHilang->sum('denda') : 0);

                    $totalBayar = $totalSewa + $totalDenda;

                    $grandSewa += $totalSewa;
                    $grandDenda += $totalDenda;
                    $grandBayar += $totalBayar;

                    $barangList = $t->detail->map(function ($d) {
                        return $d->barang->nama_barang;
                    })->implode(', ');

                    $qtyTotal = $t->detail->sum('qty');
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $t->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ $barangList }}
                    </td>

                    <td class="text-center">
                        {{ $qtyTotal }}
                    </td>

                    <td>
                        {{ ucfirst($t->status_transaksi) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($totalSewa, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="text-center">
                        Tidak ada data
                    </td>
                </tr>

            @endforelse

        </tbody>

        <tfoot>
            <tr>

                <th colspan="6" class="text-right">
                    GRAND TOTAL
                </th>

                <th class="text-right">
                    Rp {{ number_format($grandSewa, 0, ',', '.') }}
                </th>

                <th class="text-right">
                    Rp {{ number_format($grandDenda, 0, ',', '.') }}
                </th>

                <th class="text-right">
                    Rp {{ number_format($grandBayar, 0, ',', '.') }}
                </th>

            </tr>
        </tfoot>

    </table>

    {{-- ================= TTD ================= --}}
    <div class="footer">

        <div class="ttd">

            <p>
                Sukoharjo,
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>

            <p>Petugas</p>

            <div class="nama-ttd">
                {{ auth()->user()->name ?? '(................................)' }}
            </div>

        </div>

    </div>

</body>
</html>