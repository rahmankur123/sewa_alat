<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('barang_hilang', function (Blueprint $table) {
        $table->id();$table->foreignId('transaksi_id')->constrained('transaksi')->cascadeOnDelete();
        $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
        $table->integer('qty');
        $table->integer('denda');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_hilang');
    }
};
