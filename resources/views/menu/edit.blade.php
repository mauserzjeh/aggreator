@extends('layouts.application', [
    'active_page' => 'menu'
])
@section('title', 'Edit item')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-6 order-x1-0">
            <form id="item-form" action="{{ route('menu.save', ['itemId' => $item->id ?? 0]) }}" method="post">
                @csrf
                <input type="hidden" value="{{ $item->id ?? 0 }}" name="item_id">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit item</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('menu') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" class="form-control" placeholder="Name" value="{{ old('name') ?? $item->name ?? '' }}" name="name">
                                        @include('components.form-feedback', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-price">Price</label>
                                        <input type="number" id="input-price" class="form-control" placeholder="12.5" value="{{ old('price') ?? $item->price ?? '' }}" name="price">
                                        @include('components.form-feedback', ['field' => 'price'])
                                    </div>
                                </div>
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-category">Category</label>
                                        <select id="input-category" class="form-control" name="category">
                                            <option value="">Select a category...</option>
                                            @forelse($categories as $category)
                                            <option value="{{ $category->id }}" @if($item && $category->id == $item->menu_category_id) selected @endif>{{ $category->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @include('components.form-feedback', ['field' => 'category'])
                                </div>
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-allergenes">Allergenes</label>
                                        <select multiple id="input-allergenes" class="form-control" name="item_allergenes[]">
                                            @forelse($allergenes as $allergene)
                                            <option value="{{ $allergene->id }}" @if(in_array($allergene->id, $item_allergenes)) selected @endif>{{ $allergene->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @include('components.form-feedback', ['field' => 'item_allergenes'])
                                    </div>
                                </div>
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label>
                                        <textarea rows="4" class="form-control" placeholder="Description..." name="description">{{ old('description') ?? $item->description ?? '' }}</textarea>
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

@section('page-specific-scripts')
<script>
    $(() => {
        $('select#input-allergenes').select2({
            multiple: true,
            allowClear: true,
            placeholder: 'Select an allergene'
        });

        $('form#item-form').validate({
            rules: {
                name: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                category: {
                    required: true
                }
            }
        });
    });
</script>
@endsection