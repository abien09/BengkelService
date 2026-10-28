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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->date('tanggal_bayar')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->decimal('nominal_bayar', 15, 2)->nullable();
            $table->string('bukti_transfer')->nullable(); // Path foto bukti transfer
            $table->enum('status_pembayaran', ['Belum Bayar', 'Menunggu Verifikasi', 'Lunas'])->default('Belum Bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
