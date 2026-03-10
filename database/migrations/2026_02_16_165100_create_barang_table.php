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
    Schema::create('barang', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->text('deskripsi')->nullable();
        $table->string('foto')->nullable();
        $table->integer('stok');
        $table->decimal('harga_per_hari', 10, 2);
        $table->decimal('denda_kerusakan', 10, 2);
        $table->decimal('denda_keterlambatan_per_hari', 10, 2);
        $table->enum('status', ['tersedia', 'rusak', 'tidak_tersedia'])->default('tersedia');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
