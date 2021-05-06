@extends('layouts.application', [
    'active_page' => 'customer.orders'
])
@section('title', 'Order information')

@section('content')
<div class="container-fluid my-6">
    <div class="col-xl-8 order-x1-0">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Order details</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-secondary">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">General information</h6>
                <div class="row">
                    <div class="col-6">
                        <p class="h5">Created at: {{ $order->created_at }}</p>
                        <p class="h5">Customer: {{ $order->customer->name }}</p>
                        <p class="h5">City: {{ $order->city }}</p>
                        <p class="h5">ZIP: {{ $order->zip_code }}</p>
                        <p class="h5">Address: {{ $order->address }}</p>
                        <p class="h5">Phone: {{ $order->phone }}</p>
                    </div>
                    <div class="col-6">
                        <p class="h5">Restaurant: {{ $order->restaurant->name }}</p>
                        <p class="h5">Order ID: {{ $order->id }}</p>
                    </div>
                </div>
                <hr class="my-4">
                <h6 class="heading-small text-muted mb-4">Items</h6>
                <div class="table-responsive">
                    <table class="table">
                        <tbody class="list">
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-right">{{ $item->unit_price }}€</td>
                                <td>&times; {{ $item->quantity }}</td>
                                <td><i class="fas fa-equals"></i></td>
                                <td class="text-right">{{ $item->quantity * $item->unit_price }}€</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><b>Total</b></td>
                            <td class="text-right"><b>{{ $order->total_price() }}€</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection