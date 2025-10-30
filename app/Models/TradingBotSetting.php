<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingBotSetting extends Model
{
    use HasFactory;

    protected $table = 'trading_bot_settings';

    protected $fillable = [
        'name',
        'is_active',
        'initial_capital',
        'risk_per_trade',
        'stop_loss_pips',
        'take_profit_pips',
        'max_daily_trades',
        'timeframe',
        'indicators_config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'initial_capital' => 'decimal:2',
        'risk_per_trade' => 'decimal:2',
        'stop_loss_pips' => 'decimal:2',
        'take_profit_pips' => 'decimal:2',
        'indicators_config' => 'array',
    ];
}
