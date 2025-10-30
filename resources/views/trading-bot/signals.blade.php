@extends('layouts.app')

@section('title', 'Trading Signals')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    <i class="bi bi-graph-up"></i> Trading Signals
                </h2>
                <a href="{{ route('trading-bot.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>RSI</th>
                                    <th>EMA Fast</th>
                                    <th>EMA Slow</th>
                                    <th>Timeframe</th>
                                    <th>Confidence</th>
                                    <th>Analysis</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($signals as $signal)
                                <tr>
                                    <td>{{ $signal->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $signal->signal_type === 'BUY' ? 'success' : 'danger' }}">
                                            <i class="bi bi-{{ $signal->signal_type === 'BUY' ? 'arrow-up' : 'arrow-down' }}"></i>
                                            {{ $signal->signal_type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($signal->price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $signal->rsi_value < 30 ? 'success' : ($signal->rsi_value > 70 ? 'danger' : 'secondary') }}">
                                            {{ number_format($signal->rsi_value, 2) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($signal->ema_fast, 2) }}</td>
                                    <td>${{ number_format($signal->ema_slow, 2) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $signal->timeframe }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px; min-width: 80px;">
                                            <div class="progress-bar bg-{{ $signal->confidence > 70 ? 'success' : ($signal->confidence > 50 ? 'info' : 'warning') }}" 
                                                role="progressbar" 
                                                style="width: {{ $signal->confidence }}%">
                                                {{ number_format($signal->confidence, 0) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($signal->analysis, 60) }}</small>
                                    </td>
                                    <td>{{ $signal->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No signals found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $signals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
