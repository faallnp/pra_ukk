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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Diproses',
                'Selesai',
                'Ditolak',
            ])->change();

            $table->enum('payment_status', [
                'Menunggu Verifikasi',
                'Lunas',
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Diproses',
                'Selesai',
            ])->change();

            $table->enum('payment_status', [
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak',
            ])->change();
        });
    }
};
