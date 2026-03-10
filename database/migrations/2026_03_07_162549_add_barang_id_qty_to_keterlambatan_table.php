<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keterlambatan', function (Blueprint $table) {
            $table->foreignId('barang_id')->after('id')->constrained('barang')->cascadeOnDelete();
            $table->integer('qty')->after('barang_id');
        });
    }

    public function down(): void
    {
        Schema::table('keterlambatan', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropColumn(['barang_id','qty']);
        });
    }
};