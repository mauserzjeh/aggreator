@extends('layouts.application', [
    'active_page' => 'restaurant.orders'
])
@section('title', 'Orders')

@section('content')
<div class="container-fluid my-6">
    <div class="col-xl-8 order-x1-0">
        <form action="{{ route('order.update', ['orderId' => $order->id ]) }}" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Order details</h3>
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">General information</h6>
                    <p class="h5">Created at: {{ $order->created_at }}</p>
                    <p class="h5">Customer: {{ $order->customer->name }}</p>
                    <p class="h5">City: {{ $order->city }}</p>
                    <p class="h5">ZIP: {{ $order->zip_code }}</p>
                    <p class="h5">Address: {{ $order->address }}</p>
                    <p class="h5">Phone: {{ $order->phone }}</p>
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
                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Shipping & status</h6>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-courier">Courier</label>
                                <select id="input-courier" class="form-control" name="courier">
                                    <option value="">Select</option>
                                    @foreach($couriers as $courier)
                                    <option value="{{ $courier->id }}" @if($order->courier && $courier->id == $order->courier->id) selected @endif>{{ $courier->name }}</option>
                                    @endforeach
                                </select>
                                @include('components.form-feedback', ['field' => 'courier'])
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-status">Status</label>
                                <select id="input-status" class="form-control" name="status">
                                    @foreach($statuses as $value => $name)
                                    <option value="{{ $value }}" @if($order->status == $value) selected @endif>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @include('components.form-feedback', ['field' => 'courier'])
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-expected-delivery-time">Expected delivery time (minutes)</label>
                                <input class="form-control" type="number" name="expected_delivery_time" id="input-expected-delivery-time" min="0" value="{{ $order->expected_delivery_time }}">
                                @include('components.form-feedback', ['field' => 'expected_delivery_time'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection