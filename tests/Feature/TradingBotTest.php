<?php

namespace Tests\Feature;

use App\Models\TradingBotSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TradingBotTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that trading bot settings can be created
     */
    public function test_trading_bot_settings_can_be_created(): void
    {
        $settings = TradingBotSetting::create([
            'name' => 'Test Bot',
            'is_active' => true,
            'initial_capital' => 10000.00,
            'risk_per_trade' => 1.00,
            'stop_loss_pips' => 10.00,
            'take_profit_pips' => 20.00,
            'max_daily_trades' => 5,
            'timeframe' => '5m',
        ]);

        $this->assertDatabaseHas('trading_bot_settings', [
            'name' => 'Test Bot',
            'is_active' => true,
        ]);

        $this->assertEquals(10000.00, $settings->initial_capital);
        $this->assertEquals('5m', $settings->timeframe);
    }

    /**
     * Test that trading bot command exists
     */
    public function test_trading_bot_command_exists(): void
    {
        $this->artisan('trading-bot:run --help')
            ->assertExitCode(0);
    }
}
