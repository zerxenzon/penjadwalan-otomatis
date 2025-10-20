// ============================================
// 10. CREATE TABLE: kelas
// ============================================
// File: database/migrations/2025_01_01_000010_create_kelas_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            // Format: SI-R-SM3-20251 (prodi-shift-semester-angkatan)
            $table->unsignedBigInteger('angkatan_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->unique(['nama']);
            $table->foreign('angkatan_id')->references('id')->on('angkatan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shift_id')->references('id')->on('shift')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
