<!DOCTYPE html>
<html>
<head>
    <title>Nota Sewa</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            padding:40px;
            color:#1e293b;
        }

        .container{
            width:750px;
            margin:auto;
        }

        h2{
            text-align:center;
            margin-bottom:25px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        table, th, td{
            border:1px solid #334155;
        }

        th{
            background:#f1f5f9;
            text-transform:uppercase;
            font-size:12px;
        }

        th, td{
            padding:8px;
            text-align:center;
        }

        .no-border td{
            border:none;
            text-align:left;
            padding:4px;
        }

        .text-left{
            text-align:left;
        }

        .text-right{
            text-align:right;
        }

        .total{
            font-weight:bold;
            font-size:16px;
            background:#f8fafc;
        }

        .denda{
            color:#dc2626;
            font-weight:bold;
        }

        hr{
            margin:25px 0;
            border:0;
            border-top:1px solid #cbd5f5;
        }
    </style>

</head>

<body>

<div class="container">

    <h2>NOTA SEWA</h2>

    {{-- INFO --}}
    <table class="no-border">

        <tr>
            <td width="200">ID Transaksi</td>
            <td>: {{ $transaksi->id }}</td>
        </tr>

        <tr>
            <td>Nama Penyewa</td>
            <td>: {{ $transaksi->user->name }}</td>
        </tr>

        <tr>
            <td>Tanggal Pinjam</td>
            <td>: {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d-m-Y') }}</td>
        </tr>

        <tr>
            <td>Tanggal Kembali</td>
            <td>: {{ $transaksi->tanggal_kembali_real 
                ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->format('d-m-Y') 
                : '-' }}
            </td>
        </tr>

    </table>

    <hr>

    {{-- BARANG --}}
    <h3>Barang Disewa</h3>

    <table>
        <tr>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga / Hari</th>
            <th>Subtotal</th>
        </tr>

        @php $total_sewa = 0; @endphp

        @foreach($transaksi->detail as $d)

        @php
            $subtotal = $d->subtotal; // SUDAH dari DB
            $total_sewa += $subtotal;
        @endphp

        <tr>
            <td class="text-left">{{ $d->barang->nama_barang }}</td>
            <td>{{ $d->qty }}</td>
            <td class="text-right">
                Rp {{ number_format($d->harga_per_hari,0,',','.') }}
            </td>
            <td class="text-right">
                Rp {{ number_format($subtotal,0,',','.') }}
            </td>
        </tr>

        @endforeach

        <tr class="total">
            <td colspan="3" class="text-right">Total Sewa</td>
            <td class="text-right">
                Rp {{ number_format($total_sewa,0,',','.') }}
            </td>
        </tr>

    </table>

    <hr>

    {{-- DENDA KETERLAMBATAN --}}
    <h3>Denda Keterlambatan</h3>

    @if($transaksi->keterlambatan->count())

    <table>
        <tr>
            <th>Durasi</th>
            <th>Denda</th>
        </tr>

        @foreach($transaksi->keterlambatan as $k)
        <tr>
            <td>{{ $k->durasi_hari }} Hari</td>
            <td class="text-right denda">
                Rp {{ number_format($k->total_denda,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </table>

    @else
        <p>Tidak ada keterlambatan</p>
    @endif


    {{-- DENDA KERUSAKAN --}}
    <h3>Denda Kerusakan</h3>

    @if($transaksi->kerusakan->count())

    <table>
        <tr>
            <th>Barang</th>
            <th>Qty Rusak</th>
            <th>Denda</th>
        </tr>

        @foreach($transaksi->kerusakan as $k)
        <tr>
            <td class="text-left">{{ $k->barang->nama_barang }}</td>
            <td>{{ $k->qty }}</td>
            <td class="text-right denda">
                Rp {{ number_format($k->total_denda,0,',','.') }}
            </td>
        </tr>
        @endforeach

    </table>

    @else
        <p>Tidak ada kerusakan barang</p>
    @endif


    {{-- DENDA HILANG --}}
    <h3>Denda Barang Hilang</h3>

    @if($transaksi->barangHilang->count())

    <table>
        <tr>
            <th>Barang</th>
            <th>Qty</th>
            <th>Denda</th>
        </tr>

        @foreach($transaksi->barangHilang as $h)
        <tr>
            <td class="text-left">{{ $h->barang->nama_barang }}</td>
            <td>{{ $h->qty }}</td>
            <td class="text-right denda">
                Rp {{ number_format($h->denda,0,',','.') }}
            </td>
        </tr>
        @endforeach

    </table>

    @else
        <p>Tidak ada barang hilang</p>
    @endif


    <hr>

    {{-- TOTAL --}}
    @php
        $total_denda =
            $transaksi->keterlambatan->sum('total_denda') +
            $transaksi->kerusakan->sum('total_denda') +
            $transaksi->barangHilang->sum('denda');

        $total_bayar = $total_sewa + $total_denda;
    @endphp

    <table>
        <tr class="total">
            <td>Total Sewa</td>
            <td class="text-right">
                Rp {{ number_format($total_sewa,0,',','.') }}
            </td>
        </tr>

        <tr class="total">
            <td>Total Denda</td>
            <td class="text-right denda">
                Rp {{ number_format($total_denda,0,',','.') }}
            </td>
        </tr>

        <tr class="total">
            <td>Total Bayar</td>
            <td class="text-right">
                Rp {{ number_format($total_bayar,0,',','.') }}
            </td>
        </tr>
    </table>


    <br><br>

    {{-- TTD --}}
    <p style="text-align:right;">
        Petugas
        <br><br><br>
        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
    </p>

</div>

<script>
    window.print();
</script>

</body>
</html>