<h2>Terima kasih telah melakukan transaksi</h2>

<p>Nama: {{ $user->name }}</p>
<p>Total: Rp {{ number_format($transaksi->total_harga) }}</p>
<p>Status: {{ $transaksi->status_transaksi }}</p>

@if($isBaru)
<hr>
<h3>Akun Anda Belum Aktif</h3>
<p>Silakan aktivasi akun melalui link berikut:</p>

<a href="{{ url('aktivasi/'.$user->token_aktivasi) }}">
    Aktivasi Akun
</a>

<p>Token Aktivasi: {{ $user->token_aktivasi }}</p>
@endif