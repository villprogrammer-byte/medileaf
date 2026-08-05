@extends('user.layouts.app')

@section('title', 'Orders & Payments')

@section('content')

    <div class="ml-user-page-head">
        <div>
            <h1><i class="bi bi-credit-card-fill"></i> Orders &amp; Payments</h1>
            @if(!empty($search))
                <p>Showing results for "<strong>{{ $search }}</strong>" — <a href="{{ route('user.orders') }}">clear search</a></p>
            @else
                <p>Your order history and payment status.</p>
            @endif
        </div>
    </div>

    <div class="row g-4 mt-2">

        <div class="col-xl-12">

            <div class="ml-user-card">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-credit-card-fill"></i>
                        Orders &amp; Payments
                    </h4>
                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Payment Status</th>
                                <th>Invoice</th>
                                <th>Track Order</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($orders ?? [] as $order)

                                <tr>
                                    <td>{{ $order->order_id ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ ($order->payment_status ?? '') === 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $order->payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!empty($order->invoice_url))
                                            <a href="{{ $order->invoice_url }}" class="ml-action-btn edit d-inline-flex">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                        @else
                                            &mdash;
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ $order->track_url ?? '#' }}" class="ml-user-add-btn" style="min-height:38px;padding:0 16px;font-size:13px;">
                                            <i class="bi bi-truck"></i>
                                            Track
                                        </a>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="bi bi-cart-x fs-3 text-muted"></i>
                                        <p class="mb-0 mt-2 text-muted">No orders available yet.</p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
