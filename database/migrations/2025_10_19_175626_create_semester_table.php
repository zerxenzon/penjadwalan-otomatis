// ============================================
// 6. CREATE TABLE: semester
// ============================================
// File: database/migrations/2025_01_01_000006_create_semester_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('kode_semester');
            // Format: 20251 (tahun 2025, semester 1)
            $table->enum('tipe', ['ganjil', 'genap']);
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->unique(['kode_semester', 'tipe']);
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semester');
    }
};
