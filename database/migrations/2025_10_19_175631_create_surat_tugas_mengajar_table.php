// ============================================
// 12. CREATE TABLE: surat_tugas_mengajar
// ============================================
// File: database/migrations/2025_01_01_000012_create_surat_tugas_mengajar_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_tugas_mengajar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('mata_kuliah_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('status_id');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['dosen_id', 'mata_kuliah_id', 'kelas_id', 'semester_id'], 'stm_unique_assignment');
            $table->foreign('dosen_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mata_kuliah_id')->references('id')->on('mata_kuliah')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_tugas_mengajar');
    }
};
