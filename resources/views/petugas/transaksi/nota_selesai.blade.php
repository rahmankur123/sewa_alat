<!DOCTYPE html>
<html>
<head>
<title>Nota Sewa</title>

<style>

body{
font-family: Arial, Helvetica, sans-serif;
padding:40px;
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
font-size:16px;
}

hr{
margin:25px 0;
}

</style>

</head>

<body>

<div class="container">

<h2>NOTA SEWA</h2>

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

<h3>Barang Disewa</h3>

<table>

<tr>
<th>Barang</th>
<th>Qty</th>
<th>Harga Sewa</th>
<th>Total</th>
</tr>

@php
$total_sewa = 0;
@endphp

@foreach($transaksi->detail as $d)

@php
$subtotal = $d->qty * $d->barang->harga_sewa;
$total_sewa += $subtotal;
@endphp

<tr>
<td>{{ $d->barang->nama_barang }}</td>
<td>{{ $d->qty }}</td>
<td>Rp {{ number_format($d->barang->harga_sewa) }}</td>
<td>Rp {{ number_format($subtotal) }}</td>
</tr>

@endforeach

<tr class="total">
<td colspan="3">Total Sewa</td>
<td>Rp {{ number_format($total_sewa) }}</td>
</tr>

</table>


<hr>

<h3>Denda Keterlambatan</h3>

@if($transaksi->keterlambatan->count() > 0)

<table>

<tr>
<th>Durasi Telat</th>
<th>Denda</th>
</tr>

@foreach($transaksi->keterlambatan as $k)

<tr>
<td>{{ $k->durasi_hari }} Hari</td>
<td>Rp {{ number_format($k->total_denda) }}</td>
</tr>

@endforeach

</table>

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

@php

$total_denda =
$transaksi->kerusakan->sum('total_denda')
+
$transaksi->keterlambatan->sum('total_denda');

$total_bayar = $total_sewa + $total_denda;

@endphp

<table>

<tr class="total">
<td>Total Sewa</td>
<td>Rp {{ number_format($total_sewa) }}</td>
</tr>

<tr class="total">
<td>Total Denda</td>
<td>Rp {{ number_format($total_denda) }}</td>
</tr>

<tr class="total">
<td>Total Bayar</td>
<td>Rp {{ number_format($total_bayar) }}</td>
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
