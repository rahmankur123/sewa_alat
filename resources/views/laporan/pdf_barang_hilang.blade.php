<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Hilang</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        /* KOP SURAT */
        .kop-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }

        .kop-table td {
            border: none;
            vertical-align: top;
        }

        .logo {
            width: 80px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 20px;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16px;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        .line {
            border-top: 3px solid #000;
            margin-top: 8px;
            margin-bottom: 18px;
        }

        /* JUDUL */
        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .filter {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .filter p {
            margin: 2px 0;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        th {
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .ttd {
            width: 250px;
            float: right;
            text-align: center;
        }

        .nama-ttd {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('storage/logo.jpg') }}" class="logo">
            </td>

            <td class="kop-text">
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

    <div class="line"></div>

    {{-- JUDUL --}}
    <div class="judul">
        LAPORAN BARANG HILANG
    </div>

    {{-- FILTER --}}
    <div class="filter">

        @if(request('tanggal_awal') || request('tanggal_akhir'))
            <p>
                <strong>Periode :</strong>

                {{ request('tanggal_awal')
                    ? \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y')
                    : '-' }}

                s/d

                {{ request('tanggal_akhir')
                    ? \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y')
                    : '-' }}
            </p>
        @endif

        @if(request('user'))
            <p>
                <strong>Penyewa :</strong>
                {{ request('user') }}
            </p>
        @endif

        @if(request('barang'))
            <p>
                <strong>Barang :</strong>
                {{ request('barang') }}
            </p>
        @endif

    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penyewa</th>
                <th>Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Denda</th>
            </tr>
        </thead>

        <tbody>

        @php
            $no = 1;
            $grandTotal = 0;
        @endphp

        @forelse($data as $t)

            @foreach($t->hilang as $h)

                @php
                    $grandTotal += $h->denda;
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $no++ }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $t->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ $h->barang->nama_barang ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $h->qty }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($h->denda, 0, ',', '.') }}
                    </td>

                </tr>

            @endforeach

        @empty

            <tr>
                <td colspan="6" class="text-center">
                    Tidak ada data
                </td>
            </tr>

        @endforelse

        </tbody>

        <tfoot>
            <tr>
                <th colspan="5" class="text-right">
                    TOTAL
                </th>

                <th class="text-right">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>

    </table>

    {{-- FOOTER --}}
    <div class="footer">

        <div class="ttd">

            <p>
                Sukoharjo,
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>

            <p>Petugas</p>

            <div class="nama-ttd">
                {{ auth()->user()->name ?? '(............................)' }}
            </div>

        </div>

    </div>

</body>
</html>