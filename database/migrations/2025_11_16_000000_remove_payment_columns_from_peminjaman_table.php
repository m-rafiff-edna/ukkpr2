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
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'biaya',
                'bukti_pembayaran',
                'status_pembayaran',
                'waktu_pembayaran'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->decimal('biaya', 10, 2)->nullable()->after('status');
            $table->string('bukti_pembayaran')->nullable()->after('biaya');
            $table->enum('status_pembayaran', ['belum_membayar', 'menunggu_verifikasi', 'lunas'])->default('belum_membayar')->after('bukti_pembayaran');
            $table->timestamp('waktu_pembayaran')->nullable()->after('status_pembayaran');
        });
    }
};
