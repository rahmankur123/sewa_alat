<!DOCTYPE html>
<html>
<head>
    <title>Nota Denda</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            padding:40px;
            color:#333;
        }

        .container{
            max-width:700px;
            margin:auto;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            border-bottom:1px solid #ddd;
            padding-bottom:10px;
            margin-bottom:20px;
        }

        .title{
            font-size:20px;
            font-weight:bold;
        }

        .small{
            font-size:12px;
            color:#777;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:10px;
        }

        th{
            background:#f5f5f5;
            font-size:12px;
            text-transform:uppercase;
            color:#555;
        }

        th, td{
            padding:8px;
            text-align:left;
            border-bottom:1px solid #eee;
        }

        .right{
            text-align:right;
        }

        .center{
            text-align:center;
        }

        .section{
            margin-top:25px;
        }

        .total-box{
            margin-top:20px;
            padding:10px;
            border-top:2px solid #000;
            font-weight:bold;
            font-size:16px;
        }

        .text-red{
            color:#c0392b;
        }

        .footer{
            margin-top:50px;
            text-align:right;
        }

        hr{
            margin:25px 0;
            border:none;
            border-top:1px dashed #ccc;
        }

    </style>
</head>

<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <div class="title">NOTA DENDA</div>
            <div class="small">Sistem Persewaan</div>
        </div>

        <div class="small right">
            <div>No: INV-DENDA-{{ date('Ymd') }}-{{ $transaksi->id }}</div>
            <div>{{ now()->format('d M Y') }}</div>
        </div>
    </div>

    {{-- INFO --}}
    <table>
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
            <td>: {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>: {{ $transaksi->tanggal_kembali_real 
                ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->format('d M Y') 
                : '-' }}</td>
        </tr>
    </table>

    {{-- KETERLAMBATAN --}}
    <div class="section">
        <h4>Denda Keterlambatan</h4>

        @php $total_telat = 0; @endphp

        @if($transaksi->keterlambatan->count())

        <table>
            <tr>
                <th>Durasi</th>
                <th class="right">Denda</th>
            </tr>

            @foreach($transaksi->keterlambatan as $k)
            @php $total_telat += $k->total_denda; @endphp
            <tr>
                <td>{{ $k->durasi_hari }} hari</td>
                <td class="right text-red">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </td>
            </tr>
            @endforeach

        </table>

        @else
        <p class="small">Tidak ada keterlambatan</p>
        @endif
    </div>

    {{-- KERUSAKAN --}}
    <div class="section">
        <h4>Denda Kerusakan</h4>

        @php $total_rusak = 0; @endphp

        @if($transaksi->kerusakan->count())

        <table>
            <tr>
                <th>Barang</th>
                <th class="center">Qty</th>
                <th class="right">Denda</th>
            </tr>

            @foreach($transaksi->kerusakan as $k)
            @php $total_rusak += $k->total_denda; @endphp
            <tr>
                <td>{{ $k->barang->nama_barang }}</td>
                <td class="center">{{ $k->qty }}</td>
                <td class="right text-red">
                    Rp {{ number_format($k->total_denda,0,',','.') }}
                </td>
            </tr>
            @endforeach

        </table>

        @else
        <p class="small">Tidak ada kerusakan barang</p>
        @endif
    </div>

    {{-- TOTAL --}}
    @php
        $grand_total = $total_telat + $total_rusak;
    @endphp

    <div class="total-box">
        <div style="display:flex; justify-content:space-between;">
            <span>Total Denda</span>
            <span class="text-red">
                Rp {{ number_format($grand_total,0,',','.') }}
            </span>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Petugas</p>
        <br><br><br>
        <p>____________________</p>
    </div>

</div>

<script>
window.print();
</script>

</body>
</html>