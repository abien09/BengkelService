<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->enum('device_type', ['HP', 'Laptop', 'PC', 'Monitor', 'Tablet'])->after('nama_part')->default('Laptop');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('device_type');
        });
    }
};