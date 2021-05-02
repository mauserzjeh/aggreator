@extends('layouts.application', [
    'active_page' => 'customer.orders'
])

@section('title', 'My orders')
@section('content')
<div class="container-fluid my-6">
    @include('components.datatable-filter', [
        'route' => route('customer.orders'),
        'rows' => [
            [
                [
                    'id' => 'id',
                    'label' => 'ID'
                ],
                [
                    'id' => 'restaurant',
                    'label' => 'Restaurant',
                    'type' => 'select',
                    'options' => $restaurants
                ],
                [
                    'id' => 'status',
                    'label' => 'Status',
                    'type' => 'select',
                    'options' => $statuses
                ],
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'restaurant_name' => 'Restaurant',
            'status' => 'Status',
            'total' => 'Total',
            'created_at' => 'Created at'
        ],
        'data' => $orders,
        'actions' => [
            'info' => [
                'route_name' => 'customer.order.info',
                'route_idparam' => 'orderId'
            ]
        ]
    ])
</div>
@endsection