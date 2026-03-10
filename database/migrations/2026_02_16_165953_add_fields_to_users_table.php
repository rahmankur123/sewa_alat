<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('alamat')->nullable();
        $table->string('foto')->nullable();
        $table->enum('role', ['pemilik','petugas','anggota'])->default('anggota');
        $table->enum('status', ['aktif','belum_aktif'])->default('belum_aktif');
        $table->string('token_aktivasi')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['alamat','foto','role','status','token_aktivasi']);
    });
}

};
