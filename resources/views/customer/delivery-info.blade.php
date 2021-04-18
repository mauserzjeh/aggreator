@extends('layouts.application', [
    'active_page' => 'deliveryinfo'
])
@section('title', 'Delivery information')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-6 order-x1-0">
            <form action="{{ route('deliveryinfo.update') }}" id="delivery-info-form" method="POST">
                @csrf 
                <input type="hidden" name="deliveryinfo_id" value="{{ $deliveryinfo->id ?? 0 }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit delivery information</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">Delivery information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-city" class="form-control-label">City</label>
                                        <input id="input-city" type="text" class="form-control" name="city" value="{{ $deliveryinfo->city ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'city'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-zip" class="form-control-label">ZIP</label>
                                        <input id="input-zip" type="text" class="form-control" name="zip_code" value="{{ $deliveryinfo->zip_code ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'zip_code'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-address" class="form-control-label">Address</label>
                                        <input id="input-address" type="text" class="form-control" name="address" value="{{ $deliveryinfo->address ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'address'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="input-phone" class="form-control-label">Phone</label>
                                        <input id="input-phone" type="text" class="form-control" name="phone" value="{{ $deliveryinfo->phone ?? '' }}">
                                        @include('components.form-feedback', ['field' => 'phone'])
                                    </div>
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