<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyewaan</title>
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

        .total {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PENYEWAAN</h2>
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
                        return $d->qty * $d->harga_per_hari;
                    });

                    $totalDenda =
                        ($t->kerusakan ? $t->kerusakan->sum('total_denda') : 0) +
                        ($t->keterlambatan ? $t->keterlambatan->sum('total_denda') : 0) +
                        ($t->hilang ? $t->hilang->sum('denda') : 0);

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
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>{{ $barangList }}</td>
                    <td class="text-center">{{ $qtyTotal }}</td>
                    <td>{{ ucfirst($t->status_transaksi) }}</td>
                    <td class="text-right">Rp {{ number_format($totalSewa, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">GRAND TOTAL</th>
                <th class="text-right">Rp {{ number_format($grandSewa, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($grandDenda, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($grandBayar, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>