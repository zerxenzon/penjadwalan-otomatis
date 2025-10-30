@extends('layouts.app')

@section('title', 'Trading Bot Settings')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="bi bi-gear"></i> Trading Bot Settings
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('trading-bot.settings.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Bot Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                    {{ $settings->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $settings->is_active ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                            <small class="text-muted">Enable or disable the trading bot</small>
                        </div>

                        <div class="mb-3">
                            <label for="initial_capital" class="form-label">Initial Capital ($)</label>
                            <input type="number" step="0.01" class="form-control @error('initial_capital') is-invalid @enderror" 
                                id="initial_capital" name="initial_capital" value="{{ old('initial_capital', $settings->initial_capital) }}" required>
                            @error('initial_capital')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Starting capital for trading</small>
                        </div>

                        <div class="mb-3">
                            <label for="risk_per_trade" class="form-label">Risk Per Trade (%)</label>
                            <input type="number" step="0.1" class="form-control @error('risk_per_trade') is-invalid @enderror" 
                                id="risk_per_trade" name="risk_per_trade" value="{{ old('risk_per_trade', $settings->risk_per_trade) }}" required>
                            @error('risk_per_trade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Percentage of capital to risk per trade (0.1 - 10%)</small>
                        </div>

                        <div class="mb-3">
                            <label for="stop_loss_pips" class="form-label">Stop Loss (Pips)</label>
                            <input type="number" step="0.01" class="form-control @error('stop_loss_pips') is-invalid @enderror" 
                                id="stop_loss_pips" name="stop_loss_pips" value="{{ old('stop_loss_pips', $settings->stop_loss_pips) }}" required>
                            @error('stop_loss_pips')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Stop loss distance in pips</small>
                        </div>

                        <div class="mb-3">
                            <label for="take_profit_pips" class="form-label">Take Profit (Pips)</label>
                            <input type="number" step="0.01" class="form-control @error('take_profit_pips') is-invalid @enderror" 
                                id="take_profit_pips" name="take_profit_pips" value="{{ old('take_profit_pips', $settings->take_profit_pips) }}" required>
                            @error('take_profit_pips')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Take profit distance in pips</small>
                        </div>

                        <div class="mb-3">
                            <label for="max_daily_trades" class="form-label">Max Daily Trades</label>
                            <input type="number" class="form-control @error('max_daily_trades') is-invalid @enderror" 
                                id="max_daily_trades" name="max_daily_trades" value="{{ old('max_daily_trades', $settings->max_daily_trades) }}" required>
                            @error('max_daily_trades')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maximum number of trades per day</small>
                        </div>

                        <div class="mb-3">
                            <label for="timeframe" class="form-label">Timeframe</label>
                            <select class="form-select @error('timeframe') is-invalid @enderror" id="timeframe" name="timeframe" required>
                                <option value="1m" {{ $settings->timeframe === '1m' ? 'selected' : '' }}>1 Minute</option>
                                <option value="5m" {{ $settings->timeframe === '5m' ? 'selected' : '' }}>5 Minutes</option>
                                <option value="15m" {{ $settings->timeframe === '15m' ? 'selected' : '' }}>15 Minutes</option>
                                <option value="30m" {{ $settings->timeframe === '30m' ? 'selected' : '' }}>30 Minutes</option>
                                <option value="1h" {{ $settings->timeframe === '1h' ? 'selected' : '' }}>1 Hour</option>
                                <option value="4h" {{ $settings->timeframe === '4h' ? 'selected' : '' }}>4 Hours</option>
                            </select>
                            @error('timeframe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Trading timeframe for analysis</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('trading-bot.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>About Gold Scalping Strategy</h5>
                </div>
                <div class="card-body">
                    <p><strong>Strategy Overview:</strong></p>
                    <ul>
                        <li>Uses RSI (Relative Strength Index) to identify overbought/oversold conditions</li>
                        <li>Employs EMA crossovers (9 and 21 periods) for trend confirmation</li>
                        <li>Generates BUY signals when RSI < 35 and fast EMA crosses above slow EMA</li>
                        <li>Generates SELL signals when RSI > 65 and fast EMA crosses below slow EMA</li>
                        <li>Scalping approach targets quick profits with tight stop losses</li>
                    </ul>

                    <p><strong>Risk Management:</strong></p>
                    <ul>
                        <li>Position sizing based on risk percentage per trade</li>
                        <li>Automatic stop loss and take profit levels</li>
                        <li>Maximum daily trade limit to prevent over-trading</li>
                        <li>Only one open position at a time</li>
                    </ul>

                    <p class="text-warning"><strong>⚠️ Disclaimer:</strong> This is a demonstration trading bot. Always test with demo accounts first and never risk more than you can afford to lose.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
