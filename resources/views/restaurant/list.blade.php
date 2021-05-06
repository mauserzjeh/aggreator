@extends('layouts.application', [
    'active_page' => 'restaurants'
])
@section('title', 'Restaurants')

@section('content')
<div class="container-fluid mt-6 mb-6">
    @include('components.datatable-filter', [
        'route' => route('restaurants'),
        'rows' => [
            [
                [
                    'id' => 'name',
                    'label' => 'Name'
                ],
                [
                    'id' => 'zip',
                    'label' => 'ZIP'
                ],
                [
                    'id' => 'city',
                    'label' => 'City'
                ],
                [
                    'id' => 'address',
                    'label' => 'Address'
                ],
                [
                    'id' => 'style',
                    'label' => 'Style',
                    'type' => 'select',
                    'options' => $styles
                ]
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'name' => 'Name',
            'zip_code' => 'ZIP',
            'city' => 'City',
            'address' => 'Address',
            'styles' => 'Styles'
        ],
        'data' => $restaurants,
        'actions' => [
            'info' => [
                'route_name' => 'restaurant.info',
                'route_idparam' => 'restaurantId'
            ]
        ]
    ])
</div>
@endsection