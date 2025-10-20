// ============================================
// 5. CREATE TABLE: angkatan
// ============================================
// File: database/migrations/2025_01_01_000005_create_angkatan_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angkatan', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('tahun');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->unique(['tahun', 'status_id']);
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angkatan');
    }
};
