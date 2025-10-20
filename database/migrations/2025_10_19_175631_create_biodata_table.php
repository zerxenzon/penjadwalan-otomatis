// ============================================
// 11. CREATE TABLE: biodata
// ============================================
// File: database/migrations/2025_01_01_000011_create_biodata_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('nik', 20)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->char('gender', 1)->nullable();
            // L = Laki-laki, P = Perempuan
            $table->char('agama', 1)->nullable();
            // I = Islam, C = Catholic, K = Kristen, H = Hindu, B = Buddha, K = Kong Hu Cu
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
