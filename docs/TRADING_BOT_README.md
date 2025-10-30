# Gold Scalping AI Trading Bot

An AI-powered trading bot for gold scalping strategies integrated into the Laravel application.

## Overview

This trading bot implements a scalping strategy for gold trading using technical indicators and automated risk management.

## Features

### 1. **Technical Analysis**
- **RSI (Relative Strength Index)**: Identifies overbought/oversold conditions
- **EMA (Exponential Moving Average)**: Fast (9) and Slow (21) periods for trend detection
- **MACD**: Moving Average Convergence Divergence for momentum analysis
- **Trend Detection**: Automatic bullish/bearish trend identification

### 2. **Trading Strategy**
- **Buy Signals**: Generated when:
  - RSI < 35 (oversold)
  - Fast EMA crosses above Slow EMA (bullish crossover)
  - Overall trend is BULLISH
  
- **Sell Signals**: Generated when:
  - RSI > 65 (overbought)
  - Fast EMA crosses below Slow EMA (bearish crossover)
  - Overall trend is BEARISH

### 3. **Risk Management**
- Configurable position sizing based on risk percentage
- Automatic stop loss placement
- Automatic take profit targets
- Maximum daily trade limits
- Only one open position at a time

### 4. **Configuration**
- Initial capital setting
- Risk per trade (0.1% - 10%)
- Stop loss distance (in pips)
- Take profit distance (in pips)
- Maximum daily trades
- Trading timeframe (1m, 5m, 15m, 30m, 1h, 4h)

## Installation & Setup

### 1. Run Migrations
```bash
php artisan migrate
```

This creates three tables:
- `trading_bot_settings`: Bot configuration
- `trading_signals`: Generated trading signals
- `trades`: Executed trades history

### 2. Access the Dashboard
Navigate to `/trading-bot` to access the trading bot dashboard.

### 3. Configure Settings
1. Go to Settings page
2. Set your initial capital
3. Configure risk parameters
4. Choose your timeframe
5. Activate the bot

## Usage

### Web Interface

#### Dashboard (`/trading-bot`)
- View real-time statistics
- See recent trades and signals
- Control bot activation
- Run bot manually
- Monitor open trades

#### Settings (`/trading-bot/settings`)
- Configure all bot parameters
- Enable/disable bot
- Set risk management rules

#### Trades View (`/trading-bot/trades`)
- View all historical trades
- Filter by status (OPEN, CLOSED, CANCELLED)
- See profit/loss details

#### Signals View (`/trading-bot/signals`)
- View all generated signals
- See technical indicator values
- Check signal confidence scores

### Command Line

#### Run Bot
```bash
php artisan trading-bot:run
```

This will:
1. Analyze market data
2. Generate trading signals
3. Execute trades if conditions are met
4. Monitor existing trades

#### Monitor Only
```bash
php artisan trading-bot:run --monitor
```

This will only check and close existing trades based on stop loss/take profit.

### Scheduled Execution

To run the bot automatically, add to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Run every 5 minutes
    $schedule->command('trading-bot:run')
             ->everyFiveMinutes()
             ->when(function () {
                 return TradingBotSetting::first()->is_active ?? false;
             });
    
    // Monitor trades every minute
    $schedule->command('trading-bot:run --monitor')
             ->everyMinute();
}
```

## API Endpoints

All endpoints require authentication.

### GET `/trading-bot`
Dashboard view

### GET `/trading-bot/settings`
Settings form

### POST `/trading-bot/settings`
Update settings

### POST `/trading-bot/toggle-status`
Toggle bot active/inactive status

### POST `/trading-bot/run`
Run bot manually (returns JSON)

### POST `/trading-bot/monitor`
Monitor trades (returns JSON)

### GET `/trading-bot/statistics`
Get bot statistics (returns JSON)

### GET `/trading-bot/trades`
View all trades

### GET `/trading-bot/signals`
View all signals

### POST `/trading-bot/trades/{trade}/close`
Manually close a trade

## Database Schema

### trading_bot_settings
- `id`: Primary key
- `name`: Bot name
- `is_active`: Active status
- `initial_capital`: Starting capital
- `risk_per_trade`: Risk percentage per trade
- `stop_loss_pips`: Stop loss distance
- `take_profit_pips`: Take profit distance
- `max_daily_trades`: Maximum trades per day
- `timeframe`: Trading timeframe
- `indicators_config`: JSON config for indicators

### trading_signals
- `id`: Primary key
- `signal_type`: BUY or SELL
- `price`: Current price
- `rsi_value`: RSI indicator value
- `ema_fast`: Fast EMA value
- `ema_slow`: Slow EMA value
- `timeframe`: Timeframe used
- `confidence`: Signal confidence (0-100)
- `analysis`: Human-readable analysis

### trades
- `id`: Primary key
- `signal_id`: Foreign key to trading_signals
- `trade_type`: BUY or SELL
- `status`: OPEN, CLOSED, or CANCELLED
- `entry_price`: Entry price
- `exit_price`: Exit price (null if open)
- `stop_loss`: Stop loss price
- `take_profit`: Take profit price
- `position_size`: Position size in lots
- `profit_loss`: Calculated P/L
- `timeframe`: Timeframe used
- `entry_time`: Entry timestamp
- `exit_time`: Exit timestamp
- `notes`: Additional notes

## Architecture

### Services

#### TechnicalIndicatorService
Calculates technical indicators:
- RSI calculation
- EMA calculation
- SMA calculation
- MACD calculation
- Trend detection

#### SignalAnalyzerService
Analyzes market data and generates signals:
- Market analysis
- Signal generation
- Confidence calculation
- Stop loss/take profit calculation

#### TradingBotService
Main bot service:
- Bot execution
- Trade execution
- Position sizing
- Trade monitoring
- Statistics calculation

### Models

#### TradingBotSetting
Bot configuration model

#### TradingSignal
Trading signal model with relationship to trades

#### Trade
Trade model with profit/loss calculations and close methods

### Controller

#### TradingBotController
Handles all HTTP requests for the trading bot interface

## Testing

### Manual Testing
1. Set initial capital to $10,000
2. Set risk per trade to 1%
3. Set stop loss to 10 pips
4. Set take profit to 20 pips
5. Activate bot
6. Run bot manually
7. Check if signal is generated
8. Verify trade execution
9. Monitor trade closing

### Unit Tests
```bash
php artisan test --filter TradingBot
```

## Important Notes

### ⚠️ Disclaimer
This is a **demonstration/educational** trading bot. It uses simulated market data for gold prices.

**DO NOT use with real money without:**
1. Integrating with a real trading API (e.g., MetaTrader, Interactive Brokers)
2. Implementing real-time price feeds
3. Extensive backtesting
4. Paper trading validation
5. Proper error handling
6. Redundancy and failsafes

### Limitations
- Uses simulated price data (not real market data)
- Simplified position sizing calculation
- No connection to real trading platforms
- No real-time market data feeds
- Basic technical indicators only
- No advanced risk management features

### Production Requirements
For production use, you would need to:
1. Integrate with a broker API (MT4/MT5, OANDA, etc.)
2. Implement real-time WebSocket price feeds
3. Add proper error handling and logging
4. Implement position size calculation based on account equity
5. Add multiple timeframe analysis
6. Implement additional indicators (Bollinger Bands, Fibonacci, etc.)
7. Add backtesting framework
8. Implement trade journal and analytics
9. Add notification system (email, SMS, Telegram)
10. Implement circuit breakers and safety mechanisms

## Support & Contribution

This module is part of the larger university scheduling system. For issues or contributions related to the trading bot, please create a separate issue tagged with `trading-bot`.

## License

This trading bot module follows the same license as the main application (MIT License).
