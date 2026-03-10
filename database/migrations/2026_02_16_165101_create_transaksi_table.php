<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users');
    $table->date('tanggal_pinjam');
    $table->date('tanggal_kembali_rencana');
    $table->date('tanggal_kembali_real')->nullable();
    $table->decimal('total_harga', 10, 2)->default(0);
    $table->decimal('total_denda', 10, 2)->default(0);
    $table->enum('status_transaksi', ['dipinjam','selesai','dibatalkan'])->default('dipinjam');
    $table->enum('status_pembayaran', ['belum_bayar','lunas'])->default('belum_bayar');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
