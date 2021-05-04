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
        'rows' => []
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID'
        ],
        'data' => $discounts,
        'actions' => [
            'edit' => [
                'route_name' => 'discount.edit',
                'route_idparam' => 'discountId'
            ]
        ]
    ])

</div>
@endsection