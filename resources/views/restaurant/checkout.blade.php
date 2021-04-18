@extends('layouts.application', [
    'active_page' => 'restaurants'
])
@section('title', 'Restaurant checkout')

@section('content')
<div class="container-fluid my-6">
    <div class="row">
        <div class="col-xl-10 order-x1-0">
            <form id="restaurant-checkout-form" action="{{ route('finalize.order', ['restaurantId' => $restaurant_id]) }}" method="post">
                @csrf
                <input type="hidden" value="{{ $restaurant_id }}" name="restaurant_id">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Order checkout</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('restaurant.info', ['restaurantId' => $restaurant_id]) }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Finalize order</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">Delivery information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-city">City</label>
                                        <input type="text" id="input-city" class="form-control" placeholder="City" value="{{ $deliveryinfo->city ?? '' }}" name="city">
                                        @include('components.form-feedback', ['field' => 'city'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-zip">ZIP</label>
                                        <input type="text" id="input-zip" class="form-control" placeholder="ZIP" value="{{ $deliveryinfo->zip_code ?? '' }}" name="zip_code">
                                        @include('components.form-feedback', ['field' => 'zip_code'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Address</label>
                                        <input type="text" id="input-address" class="form-control" placeholder="Address" value="{{ $deliveryinfo->address ?? '' }}" name="address">
                                        @include('components.form-feedback', ['field' => 'address'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone</label>
                                        <input type="text" id="input-phone" class="form-control" placeholder="Phone" value="{{ $deliveryinfo->phone ?? '' }}" name="phone">
                                        @include('components.form-feedback', ['field' => 'phone'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h6 class="heading-small text-muted mb-4">Ordered items</h6>
                        <div class="pl-lg-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody class="list">
                                    @foreach($order_items as $item)
                                        <tr>
                                            <input type="hidden" value="{{ $item->id }}" name="order_items[]">
                                            <input type="hidden" value="{{ $item->price }}" disabled class="price-hidden">
                                            <td>{{ $item->name }}</td>
                                            <td class="text-right item-price">{{ $item->price }}€</td>
                                            <td>&times;</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <input class="form-control form-control-sm order-quantity" type="number" name="order_quantities[]" value=1 min=0>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right item-price-final">{{ $item->price }}€</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4"><b>Total</b></td>
                                        <td class="text-right"><b id="overall-price">{{ $total_price }}€</b></td>
                                    </tr>
                                    </tbody>
                                </table>
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
        $('input.order-quantity').on('change', function() {
            let quantity = $(this).val();
            let price = $(this).closest('tr').find('input.price-hidden').val();
            let final_price = $(this).closest('tr').find('td.item-price-final');
            let overall_price = $('b#overall-price');

            fp = quantity * price;
            final_price.html(fp + "€");

            op = 0;
            $('input.price-hidden').each(function() {
                let q = $(this).closest('tr').find('input.order-quantity').val();
                op += (q * $(this).val());
            });

            overall_price.html(op + "€");
        });

        $('form#restaurant-checkout-form').validate({
            rules: {
                city: {
                    required: true
                },
                zip_code: {
                    required: true
                },
                address: {
                    required: true
                },
                phone: {
                    required: true
                }
            }
        })
    });
</script>
@endsection