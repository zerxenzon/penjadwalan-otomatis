// ============================================
// 13. CREATE TABLE: jadwal
// ============================================
// File: database/migrations/2025_01_01_000013_create_jadwal_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_tugas_mengajar_id')->nullable()
                  ->constrained('surat_tugas_mengajar')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('shift_id');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->unique(['surat_tugas_mengajar_id', 'hari', 'jam_mulai']);
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id')->references('id')->on('shift')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
