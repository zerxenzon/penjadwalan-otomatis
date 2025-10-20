// ============================================
// 4. CREATE TABLE: prodi
// ============================================
// File: database/migrations/2025_01_01_000004_create_prodi_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('kode', 10)->unique();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
