<?php

namespace App\Services;

use App\Models\TradingSignal;

/**
 * Signal Analyzer Service
 * Analyzes market data and generates trading signals
 */
class SignalAnalyzerService
{
    protected TechnicalIndicatorService $indicatorService;

    public function __construct(TechnicalIndicatorService $indicatorService)
    {
        $this->indicatorService = $indicatorService;
    }

    /**
     * Analyze market data and generate trading signal
     * 
     * @param array $priceData Historical price data
     * @param string $timeframe Trading timeframe
     * @return TradingSignal|null Generated signal or null if no signal
     */
    public function analyzeMarket(array $priceData, string $timeframe = '5m'): ?TradingSignal
    {
        if (count($priceData) < 20) {
            return null; // Insufficient data
        }

        $currentPrice = end($priceData);
        
        // Calculate indicators
        $rsi = $this->indicatorService->calculateRSI($priceData);
        $emaFast = $this->indicatorService->calculateEMA($priceData, 9);
        $emaSlow = $this->indicatorService->calculateEMA($priceData, 21);
        
        // Detect trend
        $trend = $this->indicatorService->detectTrend($emaFast, $emaSlow);
        
        // Generate signal based on scalping strategy
        $signal = $this->generateScalpingSignal($rsi, $emaFast, $emaSlow, $trend);
        
        if ($signal) {
            $confidence = $this->calculateConfidence($rsi, $emaFast, $emaSlow, $trend);
            
            return TradingSignal::create([
                'signal_type' => $signal,
                'price' => $currentPrice,
                'rsi_value' => $rsi,
                'ema_fast' => $emaFast,
                'ema_slow' => $emaSlow,
                'timeframe' => $timeframe,
                'confidence' => $confidence,
                'analysis' => $this->generateAnalysis($rsi, $emaFast, $emaSlow, $trend),
            ]);
        }

        return null;
    }

    /**
     * Generate scalping signal based on indicators
     * 
     * @param float $rsi RSI value
     * @param float $emaFast Fast EMA
     * @param float $emaSlow Slow EMA
     * @param string $trend Market trend
     * @return string|null 'BUY', 'SELL', or null
     */
    protected function generateScalpingSignal(float $rsi, float $emaFast, float $emaSlow, string $trend): ?string
    {
        // Scalping strategy rules:
        // BUY: RSI oversold (< 30) + bullish crossover + uptrend
        // SELL: RSI overbought (> 70) + bearish crossover + downtrend
        
        $emaCrossover = $emaFast - $emaSlow;
        
        // Buy signal
        if ($rsi < 35 && $emaCrossover > 0 && $trend === 'BULLISH') {
            return 'BUY';
        }
        
        // Sell signal
        if ($rsi > 65 && $emaCrossover < 0 && $trend === 'BEARISH') {
            return 'SELL';
        }
        
        // Alternative: Strong momentum signals
        if ($rsi < 25 && $emaCrossover > 1) {
            return 'BUY';
        }
        
        if ($rsi > 75 && $emaCrossover < -1) {
            return 'SELL';
        }
        
        return null;
    }

    /**
     * Calculate signal confidence score
     * 
     * @param float $rsi RSI value
     * @param float $emaFast Fast EMA
     * @param float $emaSlow Slow EMA
     * @param string $trend Market trend
     * @return float Confidence score (0-100)
     */
    protected function calculateConfidence(float $rsi, float $emaFast, float $emaSlow, string $trend): float
    {
        $confidence = 50; // Base confidence
        
        // RSI contribution
        if ($rsi < 30 || $rsi > 70) {
            $confidence += 20;
        }
        
        // EMA crossover strength
        $emaDiff = abs($emaFast - $emaSlow);
        $confidence += min($emaDiff * 2, 20);
        
        // Trend alignment
        if ($trend !== 'NEUTRAL') {
            $confidence += 10;
        }
        
        return min(round($confidence, 2), 100);
    }

    /**
     * Generate human-readable analysis
     * 
     * @param float $rsi RSI value
     * @param float $emaFast Fast EMA
     * @param float $emaSlow Slow EMA
     * @param string $trend Market trend
     * @return string Analysis text
     */
    protected function generateAnalysis(float $rsi, float $emaFast, float $emaSlow, string $trend): string
    {
        $analysis = [];
        
        // RSI analysis
        if ($rsi < 30) {
            $analysis[] = "RSI is oversold at {$rsi}, indicating potential buying opportunity";
        } elseif ($rsi > 70) {
            $analysis[] = "RSI is overbought at {$rsi}, indicating potential selling opportunity";
        } else {
            $analysis[] = "RSI is neutral at {$rsi}";
        }
        
        // EMA analysis
        if ($emaFast > $emaSlow) {
            $analysis[] = "Fast EMA ({$emaFast}) is above Slow EMA ({$emaSlow}), bullish crossover";
        } else {
            $analysis[] = "Fast EMA ({$emaFast}) is below Slow EMA ({$emaSlow}), bearish crossover";
        }
        
        // Trend analysis
        $analysis[] = "Overall trend: {$trend}";
        
        return implode('. ', $analysis);
    }

    /**
     * Get recommended stop loss and take profit levels
     * 
     * @param string $signalType 'BUY' or 'SELL'
     * @param float $entryPrice Entry price
     * @param float $stopLossPips Stop loss in pips
     * @param float $takeProfitPips Take profit in pips
     * @return array ['stop_loss' => float, 'take_profit' => float]
     */
    public function calculateLevels(string $signalType, float $entryPrice, float $stopLossPips, float $takeProfitPips): array
    {
        $pipValue = 0.10; // Simplified pip value for gold
        
        if ($signalType === 'BUY') {
            $stopLoss = $entryPrice - ($stopLossPips * $pipValue);
            $takeProfit = $entryPrice + ($takeProfitPips * $pipValue);
        } else {
            $stopLoss = $entryPrice + ($stopLossPips * $pipValue);
            $takeProfit = $entryPrice - ($takeProfitPips * $pipValue);
        }
        
        return [
            'stop_loss' => round($stopLoss, 2),
            'take_profit' => round($takeProfit, 2),
        ];
    }
}
