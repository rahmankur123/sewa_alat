<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id','barang_id','qty','harga_per_hari','subtotal'
    ];

    public function barang()
{
    return $this->belongsTo(Barang::class);
}
    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
