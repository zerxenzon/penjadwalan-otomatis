<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';

    protected $fillable = [
        'signal_id',
        'trade_type',
        'status',
        'entry_price',
        'exit_price',
        'stop_loss',
        'take_profit',
        'position_size',
        'profit_loss',
        'timeframe',
        'entry_time',
        'exit_time',
        'notes',
    ];

    protected $casts = [
        'entry_price' => 'decimal:2',
        'exit_price' => 'decimal:2',
        'stop_loss' => 'decimal:2',
        'take_profit' => 'decimal:2',
        'position_size' => 'decimal:4',
        'profit_loss' => 'decimal:2',
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];

    public function signal()
    {
        return $this->belongsTo(TradingSignal::class, 'signal_id');
    }

    public function calculateProfitLoss(): float
    {
        if (! $this->exit_price) {
            return 0;
        }

        $priceDiff = $this->trade_type === 'BUY'
            ? $this->exit_price - $this->entry_price
            : $this->entry_price - $this->exit_price;

        // Simplified P&L calculation (would need pip value in real scenario)
        return round($priceDiff * $this->position_size * 100, 2);
    }

    public function close(float $exitPrice): void
    {
        $this->exit_price = $exitPrice;
        $this->exit_time = now();
        $this->status = 'CLOSED';
        $this->profit_loss = $this->calculateProfitLoss();
        $this->save();
    }
}
