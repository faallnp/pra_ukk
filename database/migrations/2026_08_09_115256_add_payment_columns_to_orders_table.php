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

            $table->string('payment_method')
                ->default('QRIS')
                ->after('status');

            $table->enum('payment_status', [
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak',
            ])->default('Menunggu Verifikasi');

            $table->string('payment_proof')
                ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'payment_method',
                'payment_status',
                'payment_proof',
            ]);

        });
    }
};
