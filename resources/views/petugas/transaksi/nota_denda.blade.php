<!DOCTYPE html>
<html>
<head>
    <title>Nota Denda</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            padding:40px;
        }

        .container{
            width:700px;
            margin:auto;
        }

        h2{
            text-align:center;
            margin-bottom:30px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid black;
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

        .total{
            font-weight:bold;
            font-size:18px;
        }

        hr{
            margin:25px 0;
        }

    </style>
</head>

<body>

<div class="container">

<h2>NOTA DENDA</h2>

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
<td>: {{ $transaksi->tanggal_pinjam }}</td>
</tr>

<tr>
<td>Tanggal Kembali</td>
<td>: {{ $transaksi->tanggal_kembali_real }}</td>
</tr>

</table>

<hr>

<h3>Denda Keterlambatan</h3>

@php
$telat = $transaksi->keterlambatan->first();
@endphp

@if($telat)

Telat {{ $telat->durasi_hari }} hari

Rp {{ number_format($telat->total_denda) }}

@else
<p>Tidak ada keterlambatan</p>

@endif


<h3>Denda Kerusakan</h3>

@if($transaksi->kerusakan->count() > 0)

<table>

<tr>
<th>Barang</th>
<th>Qty Rusak</th>
<th>Denda</th>
</tr>

@foreach($transaksi->kerusakan as $k)

<tr>
<td>{{ $k->barang->nama_barang }}</td>
<td>{{ $k->qty }}</td>
<td>Rp {{ number_format($k->total_denda) }}</td>
</tr>

@endforeach

</table>

@else

<p>Tidak ada kerusakan barang</p>

@endif


<hr>

<table>

<tr class="total">
<td>Total Denda</td>
<td>

Rp {{
    number_format(
        $transaksi->kerusakan->sum('total_denda')
        +
        $transaksi->keterlambatan->sum('total_denda')
    )
}}

</td>
</tr>

</table>


<br><br>

<p style="text-align:right;">
Petugas
<br><br><br>
____________________
</p>

</div>


<script>
window.print();
</script>

</body>
</html>