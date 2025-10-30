@extends('layouts.app')

@section('title', 'All Trades')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    <i class="bi bi-list"></i> All Trades
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
                                    <th>Status</th>
                                    <th>Entry Price</th>
                                    <th>Exit Price</th>
                                    <th>Stop Loss</th>
                                    <th>Take Profit</th>
                                    <th>Position Size</th>
                                    <th>P/L</th>
                                    <th>Entry Time</th>
                                    <th>Exit Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trades as $trade)
                                <tr>
                                    <td>{{ $trade->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $trade->trade_type === 'BUY' ? 'success' : 'danger' }}">
                                            {{ $trade->trade_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $trade->status === 'OPEN' ? 'warning' : ($trade->status === 'CLOSED' ? 'secondary' : 'dark') }}">
                                            {{ $trade->status }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($trade->entry_price, 2) }}</td>
                                    <td>{{ $trade->exit_price ? '$' . number_format($trade->exit_price, 2) : '-' }}</td>
                                    <td>${{ number_format($trade->stop_loss, 2) }}</td>
                                    <td>${{ number_format($trade->take_profit, 2) }}</td>
                                    <td>{{ $trade->position_size }}</td>
                                    <td class="fw-bold {{ $trade->profit_loss > 0 ? 'text-success' : ($trade->profit_loss < 0 ? 'text-danger' : '') }}">
                                        ${{ number_format($trade->profit_loss, 2) }}
                                    </td>
                                    <td>{{ $trade->entry_time->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $trade->exit_time ? $trade->exit_time->format('Y-m-d H:i:s') : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">No trades found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $trades->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
