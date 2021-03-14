@extends('layouts.application')
@section('title', 'Restaurant details')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit restaurant details </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="restaurant-info-form" role="form" action="{{ route('restaurant.update') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $restaurant_data->id ?? 0 }}" name="restaurant_id">
                        <h6 class="heading-small text-muted mb-4">General information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" class="form-control" placeholder="Name" value="{{ old('name') ?? $restaurant_data->name ?? '' }}" name="name">
                                        @include('components.form-feedback', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-zip-code">ZIP Code</label>
                                        <input type="text" id="input-zip-code" class="form-control" placeholder="ZIP Code" value="{{ old('zip_code') ?? $restaurant_data->zip_code ?? '' }}" name="zip_code">
                                        @include('components.form-feedback', ['field' => 'zip_code'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-city">City</label>
                                        <input type="text" id="input-city" class="form-control" placeholder="City" value="{{ old('city') ?? $restaurant_data->city ?? '' }}" name="city">
                                        @include('components.form-feedback', ['field' => 'city'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Address</label>
                                        <input type="text" id="input-address" class="form-control" placeholder="Address" value="{{ old('address') ?? $restaurant_data->address ?? '' }}" name="address">
                                        @include('components.form-feedback', ['field' => 'address'])
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-style">Style</label>
                                        <select multiple id="input-style" class="form-control" name="restaurant_tags[]">
                                            @forelse($restaurant_tags as $tag)
                                                <option value="{{ $tag->id }}" @if(in_array($tag->id, $restaurant_data_tags)) selected @endif>{{ $tag->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @include('components.form-feedback', ['field' => 'restaurant_tags'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h6 class="heading-small text-muted mb-4">Contact</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="text" id="input-email" class="form-control" placeholder="Email address" value="{{ old('email') ?? $restaurant_data->email ?? '' }}" name="email">
                                        @include('components.form-feedback', ['field' => 'email'])
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone number</label>
                                        <input type="text" id="input-phone" class="form-control" placeholder="Phone number" value="{{ old('phone') ?? $restaurant_data->phone ?? '' }}" name="phone">
                                        @include('components.form-feedback', ['field' => 'phone'])
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-mobile-phone">Mobile phone number</label>
                                        <input type="text" id="input-mobile-phone" class="form-control" placeholder="Mobile phone number" value="{{ old('mobile_phone') ?? $restaurant_data->mobile_phone ?? '' }}" name="mobile_phone">
                                        @include('components.form-feedback', ['field' => 'mobile_phone'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h6 class="heading-small text-muted mb-4">Description</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">About the restaurant</label>
                                <textarea rows="4" class="form-control" placeholder="A few words about the restaurant..." name="description">{{ old('description') ?? $restaurant_data->description ?? '' }}</textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script>
    $(() => {
        $('select#input-style').select2({
            multiple: true,
            allowClear: true,
            placeholder: 'Select the styles of the restaurant',
        });

        $('form#restaurant-info-form').validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                zip_code: {
                    required: true
                },
                city: {
                    required: true
                },
                address: {
                    required: true
                },
                email: {
                    email: true
                },
                restaurant_tags: {
                    required: true
                }
            },
            message: {
                restaurant_tags: {
                    required: 'At least one style has to be selected'
                }
            }
        });
    });
</script>
@endsection