<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    protected $table = 'keterlambatan';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'durasi_hari',
        'qty',
        'total_denda'
    ];

    // relasi ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}