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
        Schema::create('trading_bot_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Gold Scalping Bot');
            $table->boolean('is_active')->default(false);
            $table->decimal('initial_capital', 15, 2)->default(10000.00);
            $table->decimal('risk_per_trade', 5, 2)->default(1.00); // Percentage
            $table->decimal('stop_loss_pips', 8, 2)->default(10.00);
            $table->decimal('take_profit_pips', 8, 2)->default(20.00);
            $table->integer('max_daily_trades')->default(10);
            $table->string('timeframe')->default('5m'); // 1m, 5m, 15m, 1h
            $table->json('indicators_config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_bot_settings');
    }
};
