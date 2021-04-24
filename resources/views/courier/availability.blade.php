@extends('layouts.application', [
    'active_page' => 'availability'
])
@section('title', 'Availability')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-6 order-xl-0">
            <form id="availability-form" method="post" action="{{ route('availability.update') }}">
                @csrf 
                <input type="hidden" name="courier_id" value="{{ $courier_id }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit availability</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($availability as $day => $schedule)
                        <div class="mt-3">
                            <h6 class="heading-small text-muted mb-0">{{ $weekdays[$day] }}</h6>
                            @include('components.schedule-slider', [
                                'slider_id' => $day,
                                'name_low' => $day . '_b',
                                'value_low' => $schedule[0],
                                'name_high' => $day . '_e',
                                'value_high' => $schedule[1]
                            ])
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script src="/assets/js/schedule-slider.js"></script>
@endsection