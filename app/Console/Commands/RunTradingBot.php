<?php

namespace App\Console\Commands;

use App\Services\TradingBotService;
use Illuminate\Console\Command;

class RunTradingBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trading-bot:run {--monitor : Only monitor existing trades}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the gold scalping AI trading bot';

    protected TradingBotService $botService;

    /**
     * Create a new command instance.
     */
    public function __construct(TradingBotService $botService)
    {
        parent::__construct();
        $this->botService = $botService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting Trading Bot...');
        
        if ($this->option('monitor')) {
            return $this->monitorTrades();
        }

        return $this->runBot();
    }

    /**
     * Run the bot to analyze and execute trades
     */
    protected function runBot(): int
    {
        try {
            $results = $this->botService->run();
            
            $this->info("Bot Status: {$results['status']}");
            
            if (!isset($results['signal_generated'])) {
                $this->warn($results['message'] ?? 'Bot is not active');
                return Command::SUCCESS;
            }
            
            if ($results['signal_generated']) {
                $this->info('✓ Trading signal generated');
                
                if ($results['trade_executed']) {
                    $this->info('✓ Trade executed successfully');
                    
                    if (isset($results['trade'])) {
                        $trade = $results['trade'];
                        $this->table(
                            ['Field', 'Value'],
                            [
                                ['Type', $trade->trade_type],
                                ['Entry Price', $trade->entry_price],
                                ['Stop Loss', $trade->stop_loss],
                                ['Take Profit', $trade->take_profit],
                                ['Position Size', $trade->position_size],
                            ]
                        );
                    }
                } else {
                    $this->warn('✗ Trade not executed: ' . ($results['message'] ?? 'Unknown reason'));
                }
            } else {
                $this->info('No trading signal generated at this time');
            }
            
            // Also monitor existing trades
            $this->info("\nMonitoring open trades...");
            $this->monitorTrades();
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error running trading bot: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Monitor existing trades
     */
    protected function monitorTrades(): int
    {
        try {
            $results = $this->botService->monitorTrades();
            
            $this->info("Trades checked: {$results['checked']}");
            $this->info("Trades closed: {$results['closed']}");
            
            if ($results['closed'] > 0) {
                $this->info("\nClosed trades:");
                foreach ($results['trades'] as $trade) {
                    $profitLoss = $trade->profit_loss;
                    $color = $profitLoss > 0 ? 'info' : 'error';
                    $this->$color("Trade #{$trade->id}: {$trade->trade_type} - P/L: \${$profitLoss}");
                }
            }
            
            // Display statistics
            $stats = $this->botService->getStatistics();
            $this->info("\n=== Bot Statistics ===");
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Trades', $stats['total_trades']],
                    ['Open Trades', $stats['open_trades']],
                    ['Closed Trades', $stats['closed_trades']],
                    ['Win Rate', $stats['win_rate'] . '%'],
                    ['Total P/L', '$' . $stats['total_profit_loss']],
                ]
            );
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error monitoring trades: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
