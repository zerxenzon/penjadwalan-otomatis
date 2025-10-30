<?php

namespace Tests\Unit;

use App\Services\TechnicalIndicatorService;
use PHPUnit\Framework\TestCase;

class TechnicalIndicatorTest extends TestCase
{
    protected TechnicalIndicatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TechnicalIndicatorService;
    }

    /**
     * Test RSI calculation with oversold conditions
     */
    public function test_rsi_calculation_oversold(): void
    {
        // Create price data trending down (oversold)
        $prices = [100, 99, 98, 97, 96, 95, 94, 93, 92, 91, 90, 89, 88, 87, 86, 85, 84, 83, 82, 81];

        $rsi = $this->service->calculateRSI($prices);

        $this->assertLessThan(50, $rsi);
        $this->assertGreaterThanOrEqual(0, $rsi);
        $this->assertLessThanOrEqual(100, $rsi);
    }

    /**
     * Test RSI calculation with overbought conditions
     */
    public function test_rsi_calculation_overbought(): void
    {
        // Create price data trending up (overbought)
        $prices = [100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119];

        $rsi = $this->service->calculateRSI($prices);

        $this->assertGreaterThan(50, $rsi);
        $this->assertGreaterThanOrEqual(0, $rsi);
        $this->assertLessThanOrEqual(100, $rsi);
    }

    /**
     * Test EMA calculation
     */
    public function test_ema_calculation(): void
    {
        $prices = [100, 102, 104, 103, 105, 107, 106, 108, 110, 109, 111, 113];

        $ema9 = $this->service->calculateEMA($prices, 9);
        $ema21 = $this->service->calculateEMA($prices, 21);

        $this->assertIsFloat($ema9);
        $this->assertIsFloat($ema21);
        $this->assertGreaterThan(0, $ema9);
        $this->assertGreaterThan(0, $ema21);
    }

    /**
     * Test SMA calculation
     */
    public function test_sma_calculation(): void
    {
        $prices = [100, 102, 104, 106, 108];

        $sma = $this->service->calculateSMA($prices, 5);

        // Average of [100, 102, 104, 106, 108] = 104
        $this->assertEquals(104, $sma);
    }

    /**
     * Test trend detection
     */
    public function test_trend_detection_bullish(): void
    {
        $emaFast = 105.0;
        $emaSlow = 103.0;

        $trend = $this->service->detectTrend($emaFast, $emaSlow);

        $this->assertEquals('BULLISH', $trend);
    }

    /**
     * Test trend detection bearish
     */
    public function test_trend_detection_bearish(): void
    {
        $emaFast = 103.0;
        $emaSlow = 105.0;

        $trend = $this->service->detectTrend($emaFast, $emaSlow);

        $this->assertEquals('BEARISH', $trend);
    }

    /**
     * Test trend detection neutral
     */
    public function test_trend_detection_neutral(): void
    {
        $emaFast = 105.0;
        $emaSlow = 105.0;

        $trend = $this->service->detectTrend($emaFast, $emaSlow);

        $this->assertEquals('NEUTRAL', $trend);
    }

    /**
     * Test MACD calculation
     */
    public function test_macd_calculation(): void
    {
        $prices = array_fill(0, 30, 100);
        for ($i = 1; $i < 30; $i++) {
            $prices[$i] = $prices[$i - 1] + rand(-2, 3);
        }

        $macd = $this->service->calculateMACD($prices);

        $this->assertArrayHasKey('macd', $macd);
        $this->assertArrayHasKey('signal', $macd);
        $this->assertArrayHasKey('histogram', $macd);
        $this->assertIsFloat($macd['macd']);
        $this->assertIsFloat($macd['signal']);
        $this->assertIsFloat($macd['histogram']);
    }
}
