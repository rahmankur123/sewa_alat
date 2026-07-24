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
    Schema::table('kerusakan', function (Blueprint $table) {
        $table->enum('jenis_kerusakan', ['ringan', 'berat'])
              ->default('ringan')
              ->after('qty');
    });
}

public function down()
{
    Schema::table('kerusakan', function (Blueprint $table) {
        $table->dropColumn('jenis_kerusakan');
    });
}
};
