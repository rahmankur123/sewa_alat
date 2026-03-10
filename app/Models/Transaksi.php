<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id','tanggal_pinjam','tanggal_kembali_rencana',
        'tanggal_kembali_real','total_harga','total_denda',
        'status_transaksi','status_pembayaran'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
public function detail()
{
    return $this->hasMany(DetailTransaksi::class);
}
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function kerusakan()
{
    return $this->hasMany(Kerusakan::class);
}
public function keterlambatan()
{
    return $this->hasMany(Keterlambatan::class);
}
}
