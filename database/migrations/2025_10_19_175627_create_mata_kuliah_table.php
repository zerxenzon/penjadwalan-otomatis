// ============================================
// 7. CREATE TABLE: mata_kuliah
// ============================================
// File: database/migrations/2025_01_01_000007_create_mata_kuliah_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('kode', 20)->unique();
            $table->tinyInteger('sks');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
