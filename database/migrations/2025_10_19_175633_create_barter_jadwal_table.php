// ============================================
// 14. CREATE TABLE: barter_jadwal
// ============================================
// File: database/migrations/2025_01_01_000014_create_barter_jadwal_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barter_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_dosen_a_id');
            $table->unsignedBigInteger('jadwal_dosen_b_id');
            $table->unsignedBigInteger('dosen_pengaju_id');
            $table->unsignedBigInteger('dosen_tujuan_id');
            $table->unsignedBigInteger('status_id');
            $table->text('alasan')->nullable();
            $table->timestamps();

            $table->foreign('jadwal_dosen_a_id')->references('id')->on('jadwal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jadwal_dosen_b_id')->references('id')->on('jadwal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosen_pengaju_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosen_tujuan_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barter_jadwal');
    }
};
