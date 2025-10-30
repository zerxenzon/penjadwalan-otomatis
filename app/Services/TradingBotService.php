<?php

namespace App\Services;

use App\Models\Trade;
use App\Models\TradingBotSetting;
use App\Models\TradingSignal;
use Illuminate\Support\Facades\Log;

/**
 * Trading Bot Service
 * Main service for managing the trading bot operations
 */
class TradingBotService
{
    protected SignalAnalyzerService $signalAnalyzer;

    protected TechnicalIndicatorService $indicatorService;

    public function __construct(
        SignalAnalyzerService $signalAnalyzer,
        TechnicalIndicatorService $indicatorService
    ) {
        $this->signalAnalyzer = $signalAnalyzer;
        $this->indicatorService = $indicatorService;
    }

    /**
     * Run the trading bot
     *
     * @return array Bot execution results
     */
    public function run(): array
    {
        $settings = $this->getSettings();

        if (! $settings->is_active) {
            return ['status' => 'inactive', 'message' => 'Trading bot is not active'];
        }

        Log::info('Trading bot started', ['settings' => $settings->toArray()]);

        // Simulate market data (in production, this would fetch real data)
        $marketData = $this->getMarketData($settings->timeframe);

        // Analyze market and generate signal
        $signal = $this->signalAnalyzer->analyzeMarket($marketData, $settings->timeframe);

        $results = [
            'status' => 'completed',
            'signal_generated' => $signal !== null,
            'trade_executed' => false,
        ];

        if ($signal) {
            Log::info('Trading signal generated', ['signal' => $signal->toArray()]);
            $results['signal'] = $signal;

            // Check if we can open a new trade
            if ($this->canOpenTrade($settings)) {
                $trade = $this->executeTrade($signal, $settings);
                $results['trade_executed'] = true;
                $results['trade'] = $trade;
                Log::info('Trade executed', ['trade' => $trade->toArray()]);
            } else {
                $results['message'] = 'Cannot open new trade (max daily trades reached or open positions exist)';
            }
        } else {
            $results['message'] = 'No trading signal generated';
        }

        return $results;
    }

    /**
     * Execute a trade based on signal
     *
     * @param  TradingSignal  $signal  Trading signal
     * @param  TradingBotSetting  $settings  Bot settings
     * @return Trade Executed trade
     */
    protected function executeTrade(TradingSignal $signal, TradingBotSetting $settings): Trade
    {
        $levels = $this->signalAnalyzer->calculateLevels(
            $signal->signal_type,
            $signal->price,
            $settings->stop_loss_pips,
            $settings->take_profit_pips
        );

        $positionSize = $this->calculatePositionSize($settings);

        $trade = Trade::create([
            'signal_id' => $signal->id,
            'trade_type' => $signal->signal_type,
            'status' => 'OPEN',
            'entry_price' => $signal->price,
            'stop_loss' => $levels['stop_loss'],
            'take_profit' => $levels['take_profit'],
            'position_size' => $positionSize,
            'timeframe' => $signal->timeframe,
            'entry_time' => now(),
            'notes' => "Automated trade based on {$signal->analysis}",
        ]);

        return $trade;
    }

    /**
     * Calculate position size based on risk management
     *
     * @param  TradingBotSetting  $settings  Bot settings
     * @return float Position size in lots
     */
    protected function calculatePositionSize(TradingBotSetting $settings): float
    {
        $riskAmount = $settings->initial_capital * ($settings->risk_per_trade / 100);

        // Simplified position sizing (in real scenario, would consider stop loss distance)
        $positionSize = $riskAmount / 1000; // Approximate conversion

        return round(max($positionSize, 0.01), 2); // Minimum 0.01 lot
    }

    /**
     * Check if bot can open a new trade
     *
     * @param  TradingBotSetting  $settings  Bot settings
     * @return bool True if can open trade
     */
    protected function canOpenTrade(TradingBotSetting $settings): bool
    {
        // Check for open positions
        $openTrades = Trade::where('status', 'OPEN')->count();
        if ($openTrades > 0) {
            return false;
        }

        // Check daily trade limit
        $todayTrades = Trade::whereDate('entry_time', today())->count();
        if ($todayTrades >= $settings->max_daily_trades) {
            return false;
        }

        return true;
    }

    /**
     * Monitor and manage open trades
     *
     * @return array Monitoring results
     */
    public function monitorTrades(): array
    {
        $openTrades = Trade::where('status', 'OPEN')->get();
        $results = ['checked' => 0, 'closed' => 0, 'trades' => []];

        foreach ($openTrades as $trade) {
            $results['checked']++;

            // Simulate current price (in production, fetch real price)
            $currentPrice = $this->getCurrentPrice();

            // Check stop loss and take profit
            if ($this->shouldCloseTrade($trade, $currentPrice)) {
                $trade->close($currentPrice);
                $results['closed']++;
                $results['trades'][] = $trade;

                Log::info('Trade closed', [
                    'trade_id' => $trade->id,
                    'profit_loss' => $trade->profit_loss,
                ]);
            }
        }

        return $results;
    }

    /**
     * Determine if trade should be closed
     *
     * @param  Trade  $trade  Trade to check
     * @param  float  $currentPrice  Current market price
     * @return bool True if should close
     */
    protected function shouldCloseTrade(Trade $trade, float $currentPrice): bool
    {
        if ($trade->trade_type === 'BUY') {
            // Close if hit stop loss or take profit
            return $currentPrice <= $trade->stop_loss || $currentPrice >= $trade->take_profit;
        } else {
            // Close if hit stop loss or take profit
            return $currentPrice >= $trade->stop_loss || $currentPrice <= $trade->take_profit;
        }
    }

    /**
     * Get or create bot settings
     *
     * @return TradingBotSetting Bot settings
     */
    public function getSettings(): TradingBotSetting
    {
        $settings = TradingBotSetting::first();

        if (! $settings) {
            $settings = TradingBotSetting::create([
                'name' => 'Gold Scalping Bot',
                'is_active' => false,
                'initial_capital' => 10000.00,
                'risk_per_trade' => 1.00,
                'stop_loss_pips' => 10.00,
                'take_profit_pips' => 20.00,
                'max_daily_trades' => 10,
                'timeframe' => '5m',
            ]);
        }

        return $settings;
    }

    /**
     * Get simulated market data
     *
     * @param  string  $timeframe  Timeframe
     * @return array Price data
     */
    protected function getMarketData(string $timeframe): array
    {
        // Simulate gold price data (in production, fetch from API)
        $basePrice = 2650.00; // Gold price around $2650
        $prices = [];

        // Generate data with potential signal patterns
        $trend = rand(0, 1) ? 1 : -1; // Random trend direction

        for ($i = 0; $i < 50; $i++) {
            // Generate trending price movement with some noise
            $trendChange = $trend * (rand(5, 15) / 10);
            $noise = (rand(-50, 50) / 100) * (rand(1, 5) / 10);
            $basePrice += $trendChange + $noise;

            // Occasionally reverse trend
            if ($i % 15 === 0 && $i > 0) {
                $trend *= -1;
            }

            $prices[] = round($basePrice, 2);
        }

        return $prices;
    }

    /**
     * Get current market price (simulated)
     *
     * @return float Current price
     */
    protected function getCurrentPrice(): float
    {
        // In production, fetch real-time price from API
        return round(2650.00 + (rand(-100, 100) / 10), 2);
    }

    /**
     * Get bot statistics
     *
     * @return array Statistics
     */
    public function getStatistics(): array
    {
        $totalTrades = Trade::count();
        $openTrades = Trade::where('status', 'OPEN')->count();
        $closedTrades = Trade::where('status', 'CLOSED')->count();

        $profitableTrades = Trade::where('status', 'CLOSED')
            ->where('profit_loss', '>', 0)
            ->count();

        $totalProfitLoss = Trade::where('status', 'CLOSED')
            ->sum('profit_loss');

        $winRate = $closedTrades > 0
            ? round(($profitableTrades / $closedTrades) * 100, 2)
            : 0;

        return [
            'total_trades' => $totalTrades,
            'open_trades' => $openTrades,
            'closed_trades' => $closedTrades,
            'profitable_trades' => $profitableTrades,
            'win_rate' => $winRate,
            'total_profit_loss' => round($totalProfitLoss, 2),
        ];
    }
}
