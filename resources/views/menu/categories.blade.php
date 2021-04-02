@extends('layouts.application')
@section('title', 'Menu categories')

@section('content')
<div class="container-fluid mt-6 mb-6">
    <div class="mb-3">
        <a href="{{ route('menu.categories.edit', ['categoryId' => 0]) }}">
            <button class="btn btn-icon btn-primary" type="button">
                <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                <span class="btn-inner--text">New</span>
            </button>
        </a>
    </div>

    @include('components.datatable-filter', [
        'route' => route('menu.categories'),
        'rows' => [
            [
                [
                    'id' => 'id',
                    'label' => 'ID',
                ],
                [
                    'id' => 'name',
                    'label' => 'Name',
                ],
                [
                    'id' => 'slug',
                    'label' => 'Slug',
                ]
            ]
        ]
    ])

    @include('components.datatable', [
        'thead' => [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug'
        ],
        'data' => $categories,
        'actions' => [
            'edit' => [
                'route_name' => 'menu.categories.edit',
                'route_idparam' => 'categoryId'
            ],
            'delete' => [
                'route_name' => 'menu.categories.delete',
                'route_idparam' => 'categoryId'
            ]
        ]
    ])

</div>
@endsection

@section('page-specific-scripts')
<script>
    $(() => {

    })
</script>
@endsection