@extends('layouts.application', [
    'active_page' => 'discounts'
])

@section('title', 'Discounts')

@section('content')
<div class="container-fluid my-6">
    <div class="mb-3">
        <a href="{{ route('discount.edit', ['discountId' => 0]) }}">
            <button class="btn btn-icon btn-primary" type="button">
                <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                <span class="btn-inner--text">New</span>
            </button>
        </a>
    </div>

    @include('components.datatable-filter', [
        'route' => route('discounts'),
        'rows' => [
            [
                [
                    'id' => 'id',
                    'label' => 'ID'
                ],
                [
                    'id' => 'name',
                    'label' => 'Name'
                ],
                [
                    'id' => 'active',
                    'label' => 'Active',
                    'type' => 'select',
                    'options' => [
                        0 => 'Inactive',
                        1 => 'Active'
                    ]
                ],
                [
                    'id' => 'percent',
                    'label' => 'Percent',
                    'type' => 'number',
                    'relation' => true
                ]
            ],
            [
                [
                    'id' => 'start_timestamp',
                    'label' => 'Start date',
                    'type' => 'datepicker'
                ],
                [
                    'id' => 'end_timestamp',
                    'label' => 'End date',
                    'type' => 'datepicker'
                ],
                
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'name' => 'Name',
            'amount_percent' => 'Percent',
            'start_timestamp' => 'Start date',
            'end_timestamp' => 'End date',
            'active' => 'Active'
        ],
        'data' => $discounts,
        'actions' => [
            'edit' => [
                'route_name' => 'discount.edit',
                'route_idparam' => 'discountId'
            ],
            'delete' => [
                'route_name' => 'discount.delete',
                'route_idparam' => 'discountId'
            ]
        ]
    ])

</div>
@endsection