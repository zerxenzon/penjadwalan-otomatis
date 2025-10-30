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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signal_id')->nullable()->constrained('trading_signals')->onDelete('set null');
            $table->enum('trade_type', ['BUY', 'SELL'])->index();
            $table->enum('status', ['OPEN', 'CLOSED', 'CANCELLED'])->default('OPEN')->index();
            $table->decimal('entry_price', 15, 2);
            $table->decimal('exit_price', 15, 2)->nullable();
            $table->decimal('stop_loss', 15, 2);
            $table->decimal('take_profit', 15, 2);
            $table->decimal('position_size', 15, 4)->default(0.01); // Lot size
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->string('timeframe')->default('5m');
            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
