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
        Schema::create('diagnosis_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('inventory_id')->nullable()->constrained('inventories')->nullOnDelete(); // Nullable jika hanya jasa tanpa part
            $table->string('nama_tindakan');
            $table->enum('tipe_cause', ['Root Cause', 'Primary Cause', 'Secondary Cause']);
            $table->integer('qty_part')->default(1);
            $table->decimal('estimasi_biaya', 15, 2);
            $table->enum('status_persetujuan', ['Auto Approved', 'Menunggu', 'Disetujui', 'Ditolak'])->default('Auto Approved'); // Root dan Primary auto approved
            $table->text('alasan')->nullable(); // Alasan teknisi menambahkan cause ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_items');
    }
};
