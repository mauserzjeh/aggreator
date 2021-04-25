@extends('layouts.application', [
    'active_page' => 'restaurant.orders'
])

@section('title', 'Orders')
@section('content')
<div class="container-fluid mt-6 mb-6">
    @include('components.datatable-filter', [
        'route' => route('restaurant.orders'),
        'rows' => [
            [
                [
                    'id' => 'status',
                    'label' => 'Status',
                    'type' => 'select',
                    'options' => $statuses
                ],
                [
                    'id' => 'city',
                    'label' => 'City'
                ],
                [
                    'id' => 'zip',
                    'label' => 'ZIP'
                ],
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'status' => 'Status',
            'city' => 'City',
            'zip_code' => 'ZIP',
            'address' => 'Address',
            'phone' => 'Phone',
            'total' => 'Total',
            'created_at' => 'Created at'
        ],
        'data' => $orders,
        'actions' => [
            'info' => [
                'route_name' => 'order.info',
                'route_idparam' => 'orderId'
            ]
        ]
    ])
</div>
@endsection