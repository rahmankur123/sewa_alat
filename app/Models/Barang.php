<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang'; // penting karena bukan barangs

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'foto',
        'stok',
        'harga_per_hari',
        'denda_kerusakan',
        'denda_keterlambatan_per_hari',
        'status'
    ];
    public function barang()
{
    return $this->belongsTo(Barang::class);
}
public function kerusakan()
{
    return $this->hasMany(Kerusakan::class);
}
}

