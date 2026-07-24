<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name','email','password','no_hp', 'alamat','foto','role','token_aktivasi'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
    public function Barang()
    {
        return $this->hasMany(Barang::class);
    }
    
}
