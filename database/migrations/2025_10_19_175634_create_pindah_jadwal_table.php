// ============================================
// 15. CREATE TABLE: pindah_jadwal
// ============================================
// File: database/migrations/2025_01_01_000015_create_pindah_jadwal_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pindah_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('dosen_id');
            $table->text('alasan');
            $table->unsignedBigInteger('kosma_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosen_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kosma_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_jadwal');
    }
};