@extends('layouts.application', [
    'active_page' => 'courier.orders'
])

@section('title', 'Deliveries')
@section('content')
<div class="container-fluid my-6">
    @include('components.datatable-filter', [
        'route' => route('courier.orders'),
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
            'full_address' => 'Address',
            'phone' => 'Phone',
            'total' => 'Total',
            'created_at' => 'Created at'
        ],
        'data' => $orders,
        'actions' => [
            'edit' => [
                'route_name' => 'courier.order.delivered',
                'route_idparam' => 'orderId',
                'icon' => 'fas fa-check',
            ],
            'dismiss' => [
                'route_name' => 'courier.order.reject',
                'route_idparam' => 'orderId'
            ]
        ]
    ])
</div>
@endsection