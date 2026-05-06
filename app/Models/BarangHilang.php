<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BarangHilang extends Model
{
    protected $table = 'barang_hilang';
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'qty',
        'denda',
        'keterangan'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
