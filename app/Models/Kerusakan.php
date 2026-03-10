<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    protected $table = 'kerusakan';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
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