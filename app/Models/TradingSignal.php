<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingSignal extends Model
{
    use HasFactory;

    protected $table = 'trading_signals';

    protected $fillable = [
        'signal_type',
        'price',
        'rsi_value',
        'ema_fast',
        'ema_slow',
        'timeframe',
        'confidence',
        'analysis',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rsi_value' => 'decimal:2',
        'ema_fast' => 'decimal:2',
        'ema_slow' => 'decimal:2',
        'confidence' => 'decimal:2',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class, 'signal_id');
    }
}
