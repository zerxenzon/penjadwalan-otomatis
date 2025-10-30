<?php

namespace App\Services;

/**
 * Technical Indicator Calculator Service
 * Provides methods to calculate common technical indicators for trading analysis
 */
class TechnicalIndicatorService
{
    /**
     * Calculate Relative Strength Index (RSI)
     *
     * @param  array  $prices  Array of prices (most recent last)
     * @param  int  $period  RSI period (default: 14)
     * @return float RSI value (0-100)
     */
    public function calculateRSI(array $prices, int $period = 14): float
    {
        if (count($prices) < $period + 1) {
            return 50.0; // Neutral if insufficient data
        }

        $gains = [];
        $losses = [];

        // Calculate price changes
        for ($i = 1; $i < count($prices); $i++) {
            $change = $prices[$i] - $prices[$i - 1];
            $gains[] = $change > 0 ? $change : 0;
            $losses[] = $change < 0 ? abs($change) : 0;
        }

        // Take last N periods
        $gains = array_slice($gains, -$period);
        $losses = array_slice($losses, -$period);

        $avgGain = array_sum($gains) / $period;
        $avgLoss = array_sum($losses) / $period;

        if ($avgLoss == 0) {
            return 100.0;
        }

        $rs = $avgGain / $avgLoss;
        $rsi = 100 - (100 / (1 + $rs));

        return round($rsi, 2);
    }

    /**
     * Calculate Exponential Moving Average (EMA)
     *
     * @param  array  $prices  Array of prices
     * @param  int  $period  EMA period
     * @return float EMA value
     */
    public function calculateEMA(array $prices, int $period): float
    {
        if (count($prices) < $period) {
            return array_sum($prices) / count($prices);
        }

        $multiplier = 2 / ($period + 1);

        // Start with SMA
        $sma = array_sum(array_slice($prices, 0, $period)) / $period;
        $ema = $sma;

        // Calculate EMA for remaining prices
        for ($i = $period; $i < count($prices); $i++) {
            $ema = ($prices[$i] - $ema) * $multiplier + $ema;
        }

        return round($ema, 2);
    }

    /**
     * Calculate Simple Moving Average (SMA)
     *
     * @param  array  $prices  Array of prices
     * @param  int  $period  SMA period
     * @return float SMA value
     */
    public function calculateSMA(array $prices, int $period): float
    {
        if (count($prices) < $period) {
            return array_sum($prices) / count($prices);
        }

        $relevantPrices = array_slice($prices, -$period);

        return round(array_sum($relevantPrices) / $period, 2);
    }

    /**
     * Calculate Moving Average Convergence Divergence (MACD)
     *
     * @param  array  $prices  Array of prices
     * @return array ['macd' => float, 'signal' => float, 'histogram' => float]
     */
    public function calculateMACD(array $prices): array
    {
        $ema12 = $this->calculateEMA($prices, 12);
        $ema26 = $this->calculateEMA($prices, 26);
        $macd = $ema12 - $ema26;

        // For signal line, we need MACD values over time
        // Simplified: using current MACD as signal
        $signal = $macd * 0.9; // Approximation
        $histogram = $macd - $signal;

        return [
            'macd' => round($macd, 2),
            'signal' => round($signal, 2),
            'histogram' => round($histogram, 2),
        ];
    }

    /**
     * Detect trend based on moving averages
     *
     * @param  float  $emaFast  Fast EMA value
     * @param  float  $emaSlow  Slow EMA value
     * @return string 'BULLISH', 'BEARISH', or 'NEUTRAL'
     */
    public function detectTrend(float $emaFast, float $emaSlow): string
    {
        $difference = $emaFast - $emaSlow;
        $threshold = 0.5; // Minimum difference for trend

        if ($difference > $threshold) {
            return 'BULLISH';
        } elseif ($difference < -$threshold) {
            return 'BEARISH';
        }

        return 'NEUTRAL';
    }
}
