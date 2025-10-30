<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\TradingSignal;
use App\Services\TradingBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TradingBotController extends Controller
{
    protected TradingBotService $botService;

    public function __construct(TradingBotService $botService)
    {
        $this->botService = $botService;
    }

    /**
     * Display trading bot dashboard
     */
    public function index()
    {
        $settings = $this->botService->getSettings();
        $statistics = $this->botService->getStatistics();

        $recentTrades = Trade::with('signal')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentSignals = TradingSignal::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('trading-bot.index', compact('settings', 'statistics', 'recentTrades', 'recentSignals'));
    }

    /**
     * Show bot settings form
     */
    public function settings()
    {
        $settings = $this->botService->getSettings();

        return view('trading-bot.settings', compact('settings'));
    }

    /**
     * Update bot settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
            'initial_capital' => 'required|numeric|min:100',
            'risk_per_trade' => 'required|numeric|min:0.1|max:10',
            'stop_loss_pips' => 'required|numeric|min:1|max:100',
            'take_profit_pips' => 'required|numeric|min:1|max:200',
            'max_daily_trades' => 'required|integer|min:1|max:50',
            'timeframe' => 'required|in:1m,5m,15m,30m,1h,4h',
        ]);

        $settings = $this->botService->getSettings();
        $settings->update($validated);

        return redirect()->route('trading-bot.settings')
            ->with('success', 'Trading bot settings updated successfully');
    }

    /**
     * Toggle bot active status
     */
    public function toggleStatus(Request $request)
    {
        $settings = $this->botService->getSettings();
        $settings->update(['is_active' => ! $settings->is_active]);

        $status = $settings->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "Trading bot {$status} successfully",
            'is_active' => $settings->is_active,
        ]);
    }

    /**
     * Run the trading bot manually
     */
    public function run()
    {
        try {
            $results = $this->botService->run();

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error('Trading bot run failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Trading bot execution failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Monitor open trades
     */
    public function monitor()
    {
        try {
            $results = $this->botService->monitorTrades();

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error('Trade monitoring failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Trade monitoring failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get bot statistics
     */
    public function statistics()
    {
        $statistics = $this->botService->getStatistics();

        return response()->json([
            'success' => true,
            'statistics' => $statistics,
        ]);
    }

    /**
     * Show all trades
     */
    public function trades(Request $request)
    {
        $query = Trade::with('signal')->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $trades = $query->paginate(20);

        return view('trading-bot.trades', compact('trades'));
    }

    /**
     * Show all signals
     */
    public function signals(Request $request)
    {
        $query = TradingSignal::orderBy('created_at', 'desc');

        if ($request->has('signal_type')) {
            $query->where('signal_type', $request->signal_type);
        }

        $signals = $query->paginate(20);

        return view('trading-bot.signals', compact('signals'));
    }

    /**
     * Close a trade manually
     */
    public function closeTrade(Request $request, Trade $trade)
    {
        if ($trade->status !== 'OPEN') {
            return response()->json([
                'success' => false,
                'message' => 'Trade is not open',
            ], 400);
        }

        $validated = $request->validate([
            'exit_price' => 'required|numeric|min:0',
        ]);

        $trade->close($validated['exit_price']);

        return response()->json([
            'success' => true,
            'message' => 'Trade closed successfully',
            'trade' => $trade,
        ]);
    }
}
