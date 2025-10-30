<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trading_signals', function (Blueprint $table) {
            $table->id();
            $table->enum('signal_type', ['BUY', 'SELL'])->index();
            $table->decimal('price', 15, 2);
            $table->decimal('rsi_value', 8, 2)->nullable();
            $table->decimal('ema_fast', 15, 2)->nullable();
            $table->decimal('ema_slow', 15, 2)->nullable();
            $table->string('timeframe')->default('5m');
            $table->decimal('confidence', 5, 2)->default(0); // 0-100
            $table->text('analysis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_signals');
    }
};
