<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

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
    </style>
</head>
<body>

    <h2>LAPORAN KERUSAKAN BARANG</h2>
    <div class="subtitle">
        Sistem Persewaan Alat Bela Diri
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penyewa</th>
                <th>Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp

            @forelse($data as $i => $d)
                @php $grandTotal += $d->total_denda; @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $d->transaksi->user->name ?? '-' }}</td>
                    <td>{{ $d->barang->nama_barang ?? '-' }}</td>
                    <td class="text-center">{{ $d->qty }}</td>
                    <td class="text-right">
                        Rp {{ number_format($d->total_denda, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <th class="text-right">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

</body>
</html>