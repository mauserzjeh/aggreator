@extends('layouts.application', [
    'active_page' => 'discounts'
])

@section('title', 'Edit discount')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-6 order-x1-0">
            <form id="discount-form" action="{{ route('discount.save', ['discountId' => $discount->id ?? 0]) }}" method="post">
                @csrf
                <input type="hidden" name="discount_id" value="{{ $discount->id ?? 0 }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit discount</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('discounts') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="input-name" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="name" id="input-name" value="{{ old('name') ?? $discount->name ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'name'])
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-percent" class="form-control-label">Percent</label>
                                        <input class="form-control" type="number" name="amount_percent" id="input-percent" value="{{ old('amount_percent') ?? $discount->amount_percent ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'amount_percent'])
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-active" class="form-control-label">Active</label>
                                        <select name="active" id="input-active" class="form-control">
                                            <option value=0 @if($discount && $discount->active == 0) selected @endif>Inactive</option>
                                            <option value=1 @if($discount && $discount->active == 1) selected @endif>Active</option>
                                        </select>
                                        @include('components.form-feedback', ['field' => 'active'])
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-menu_items">Menu items</label>
                                        <select multiple id="input-menu_items" class="form-control" name="menu_items[]">
                                            @forelse($menu_items as $menu_item)
                                            <option value="{{ $menu_item->id }}" @if(in_array($menu_item->id, $discount_items)) selected @endif>{{ $menu_item->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @include('components.form-feedback', ['field' => 'menu_items'])
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-menu_categories">Menu categories</label>
                                        <select multiple id="input-menu_categories" class="form-control" name="menu_categories[]">
                                            @forelse($menu_categories as $menu_category)
                                            <option value="{{ $menu_category->id }}" @if(in_array($menu_category->id, $discount_categories)) selected @endif>{{ $menu_category->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @include('components.form-feedback', ['field' => 'menu_categories'])
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-start_timestamp" class="form-control-label">Start timestamp</label>
                                        <input class="form-control datepicker" type="text" name="start_timestamp" id="input-start_timestamp" value="{{ old('start_timestamp') ?? $discount->start_timestamp ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'start_timestamp'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-end_timestamp" class="form-control-label">End timestamp</label>
                                        <input class="form-control datepicker" type="text" name="end_timestamp" id="input-end_timestamp" value="{{ old('end_timestamp') ?? $discount->end_timestamp ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'end_timestamp'])
                                    </div>
                                </div>
                                

                            </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script>
    $(() => {
        $('select#input-menu_items').select2({
            multiple: true,
            allowClear: true,
            placeholder: 'Select items'
        });

        $('select#input-menu_categories').select2({
            multiple: true,
            allowClear: true,
            placeholder: 'Select categories'
        });

        $('form#discount-form').validate({
            rules: {
                name: {
                    required: true
                },
                amount_percent: {
                    min: 0,
                    max: 100
                },
                end_timestamp: {
                    greater_date: '#input-start_timestamp'
                }
            },
            messages: {
                end_timestamp: {
                    greater_date: 'Must be greater than start timestamp.'

                },
                amount_percent: {
                    min: 'Percent must be greater than or equal to 0',
                    max: 'Percent must be less than or equal to 100'
                }
            }
        })
    })
</script>
@endsection