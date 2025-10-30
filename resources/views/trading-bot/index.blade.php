@extends('layouts.app')

@section('title', 'Trading Bot Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    <i class="bi bi-robot"></i> Gold Scalping AI Trading Bot
                </h2>
                <div>
                    <button class="btn btn-{{ $settings->is_active ? 'danger' : 'success' }}" id="toggleBotStatus">
                        <i class="bi bi-power"></i>
                        {{ $settings->is_active ? 'Deactivate' : 'Activate' }} Bot
                    </button>
                    <a href="{{ route('trading-bot.settings') }}" class="btn btn-primary">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </div>
            </div>
            <div class="mt-2">
                <span class="badge bg-{{ $settings->is_active ? 'success' : 'secondary' }}">
                    Status: {{ $settings->is_active ? 'ACTIVE' : 'INACTIVE' }}
                </span>
                <span class="badge bg-info">Timeframe: {{ $settings->timeframe }}</span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Trades</h5>
                    <h2>{{ $statistics['total_trades'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Open Trades</h5>
                    <h2>{{ $statistics['open_trades'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Win Rate</h5>
                    <h2>{{ $statistics['win_rate'] }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-{{ $statistics['total_profit_loss'] >= 0 ? 'success' : 'danger' }}">
                <div class="card-body">
                    <h5 class="card-title">Total P/L</h5>
                    <h2>${{ number_format($statistics['total_profit_loss'], 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Bot Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bot Controls</h5>
                    <button class="btn btn-success" id="runBot">
                        <i class="bi bi-play-fill"></i> Run Bot Now
                    </button>
                    <button class="btn btn-info" id="monitorTrades">
                        <i class="bi bi-eye-fill"></i> Monitor Trades
                    </button>
                    <a href="{{ route('trading-bot.trades') }}" class="btn btn-secondary">
                        <i class="bi bi-list"></i> View All Trades
                    </a>
                    <a href="{{ route('trading-bot.signals') }}" class="btn btn-secondary">
                        <i class="bi bi-graph-up"></i> View All Signals
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Trades -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Trades</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Entry Price</th>
                                    <th>Exit Price</th>
                                    <th>Status</th>
                                    <th>P/L</th>
                                    <th>Entry Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTrades as $trade)
                                <tr>
                                    <td>{{ $trade->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $trade->trade_type === 'BUY' ? 'success' : 'danger' }}">
                                            {{ $trade->trade_type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($trade->entry_price, 2) }}</td>
                                    <td>{{ $trade->exit_price ? '$' . number_format($trade->exit_price, 2) : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $trade->status === 'OPEN' ? 'warning' : 'secondary' }}">
                                            {{ $trade->status }}
                                        </span>
                                    </td>
                                    <td class="{{ $trade->profit_loss > 0 ? 'text-success' : 'text-danger' }}">
                                        ${{ number_format($trade->profit_loss, 2) }}
                                    </td>
                                    <td>{{ $trade->entry_time->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No trades yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Signals -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Signals</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>RSI</th>
                                    <th>Confidence</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSignals as $signal)
                                <tr>
                                    <td>{{ $signal->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $signal->signal_type === 'BUY' ? 'success' : 'danger' }}">
                                            {{ $signal->signal_type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($signal->price, 2) }}</td>
                                    <td>{{ number_format($signal->rsi_value, 2) }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $signal->confidence }}%">
                                                {{ number_format($signal->confidence, 0) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $signal->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No signals yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle bot status
    document.getElementById('toggleBotStatus').addEventListener('click', function() {
        fetch('{{ route("trading-bot.toggle-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            }
        });
    });

    // Run bot
    document.getElementById('runBot').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Running...';
        
        fetch('{{ route("trading-bot.run") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success ? 'Bot executed successfully!' : 'Bot execution failed');
            location.reload();
        });
    });

    // Monitor trades
    document.getElementById('monitorTrades').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Monitoring...';
        
        fetch('{{ route("trading-bot.monitor") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Trades monitored. Checked: ' + data.results.checked + ', Closed: ' + data.results.closed);
            location.reload();
        });
    });
});
</script>
@endsection
