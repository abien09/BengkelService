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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $table->foreignId('teknisi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status_perbaikan', ['Menunggu Teknisi', 'Dikerjakan', 'Menunggu Persetujuan', 'Selesai', 'Batal'])->default('Menunggu Teknisi');
            $table->string('rentang_tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
