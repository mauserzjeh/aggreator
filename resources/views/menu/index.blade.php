@extends('layouts.application')
@section('title', 'Menu')

@section('content')
<div class="container-fluid mt-6 mb-6">
    <div class="mb-3">
        <a href="{{ route('menu.edit', ['itemId' => 0]) }}">
            <button class="btn btn-icon btn-primary" type="button">
                <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                <span class="btn-inner--text">New</span>
            </button>
        </a>
    </div>

    @include('components.datatable-filter', [
        'route' => route('menu'),
        'rows' => [
            [
                [
                    'id' => 'id',
                    'label' => 'ID'
                ],
                [
                    'id' => 'name',
                    'label' => 'Name',
                ],
                [
                    'id' => 'category',
                    'label' => 'Category',
                    'type' => 'select',
                    'options' => $categories
                ],
                [
                    'id' => 'allergenes',
                    'label' => 'Allergenes',
                    'type' => 'select',
                    'options' => $allergenes
                ],
                [
                    'id' => 'description',
                    'label' => 'Description'
                ]
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'name' => 'Name',
            'category' => 'Category',
            'allergenes' => 'Allergenes',
            'price' => 'Price',
        ],
        'data' => $menu_items,
        'actions' => [
            'edit' => [
                'route_name' => 'menu.edit',
                'route_idparam' => 'itemId',
            ],
            'delete' => [
                'route_name' => 'menu.delete',
                'route_idparam' => 'itemId'
            ]
        ]
    ])

</div>
@endsection