<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transaksi 
        MODIFY status_transaksi 
        ENUM('dipinjam','selesai','tersewa','terdenda') 
        NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transaksi 
        MODIFY status_transaksi 
        ENUM('dipinjam','selesai') 
        NOT NULL");
    }
};