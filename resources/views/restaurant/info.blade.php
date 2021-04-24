@extends('layouts.application', [
    'active_page' => 'restaurants'
])
@section('title', 'Restaurant info')

@section('content')
<div class="container-fluid mt-6 mb-6">
    <div class="accordion" id="restaurant-details">
        <div class="card">
            <div class="card-header" id="restaurant-details-heading" data-toggle="collapse" data-target="#restaurant-details-body" aria-expanded="true" aria-control="restaurant-details-body">
                <h3 class="mb-0">Restaurant details</h3>
            </div>
            <div id="restaurant-details-body" class="collapse show" aria-labelledby="restaurant-details-heading" data-parent="#restaurant-details">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h2>{{$info->name}}</h2>
                            <h4>ZIP: <small class="text-muted">{{ $info->zip_code }}</small></h4>
                            <h4>City: <small class="text-muted">{{ $info->city }}</small></h4>
                            <h4>Address: <small class="text-muted">{{ $info->address }}</small></h4>
                            <h4>Email: <small class="text-muted">{{ $info->email }}</small></h4>
                            <h4>Phone: <small class="text-muted">{{ $info->phone }}</small></h4>
                            <h4>Mobile phone: <small class="text-muted">{{ $info->mobile_phone }}</small></h4>
                        </div>
                        <div class="col6">
                            <h4>Description<h4>
                            <h6>{{ $info->description }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion" id="restaurant-menu">
        <div class="card">
            <div class="card-header" id="restaurant-menu-heading" data-toggle="collapse" data-target="#restaurant-menu-body" aria-expanded="true" aria-control="restaurant-menu-body">
                <h3 class="mb-0">Menu</h3>
            </div>
            <div id="restaurant-menu-body" class="collapse show" aria-labelledby="restaurant-menu-heading" data-parent="#restaurant-menu">
                <div class="card-body">
                    @include('components.form-feedback', ['field' => 'order_items'])
                    @if($menu_categories->count())
                    <form action="{{ route('restaurant.checkout', ['restaurantId' => $info->id]) }}" method="post">
                        <div class="row">
                            @csrf 
                            <div class="col-2">
                                <div class="my-3 text-left">
                                    <button type="submit" class="btn btn-primary btn-sm">Order selected</button>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="table-responsive my-3">
                                    <table class="table align-items-center">
                                        <tbody class="list">
                                            @foreach($menu_categories as $menu_category)
                                                @php 
                                                    $items = $menu_items->where('menu_category_id', $menu_category->id);
                                                @endphp
                                                @if($items->count())
                                                    <tr>
                                                        <td class="text-center menu-category" colspan="5"><h4>{{ $menu_category->name }}</h4></td>
                                                    </tr>
                                                    @foreach($items as $item)
                                                    <tr @if(!$item->description) data-toggle="tooltip" data-placement="top" title="{{ $item->description }}" @endif>
                                                        <td>{{ $item->name }}</td>
                                                        <td class="text-right">{{ $item->price }}€</td>
                                                        <td class="text-right">
                                                            @php
                                                                $allergenes = implode(', ', $item->allergenes()->pluck('name')->toArray());
                                                            @endphp
                                                            @if($allergenes)
                                                            <span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="{{ $allergenes }}">
                                                                <i class="fas fa-info-circle"></i> Allergenes
                                                            </span>
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            <label class="custom-toggle order">
                                                                <input type="checkbox" name="order_items[]" value="{{ $item->id }}">
                                                                <span class="custom-toggle-slider rounded-circle" data-label-off="Order" data-label-on="Order"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center">No items</h4>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection