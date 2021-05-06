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
                    'id' => 'priority',
                    'label' => 'Priority',
                    'type' => 'select',
                    'options' => \App\Models\Order::PRIORITIES
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
                [
                    'id' => 'created_at',
                    'label' => 'Created at',
                    'type' => 'datepicker'
                ]
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'priority' => 'Priority',
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
            ],
            'custom' => [
                [
                    'route_name' => 'courier.order.priority',
                    'route_idparam' => 'orderId',
                    'route_params' => [
                        'priority' => \App\Models\Order::PRIORITY_HIGHER
                    ],
                    'icon' => 'fas fa-arrow-up',
                    'class' => 'btn btn-sm btn-secondary',
                ],
                [
                    'route_name' => 'courier.order.priority',
                    'route_idparam' => 'orderId',
                    'route_params' => [
                        'priority' => \App\Models\Order::PRIORITY_LOWER
                    ],
                    'icon' => 'fas fa-arrow-down',
                    'class' => 'btn btn-sm btn-secondary',
                ],
            ]
        ]
    ])
</div>
@endsection