@extends('layouts.application')
@section('title', 'Edit category')

@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-6 order-x1-0">
            <form id="category-form" action="{{ route('menu.categories.save', ['categoryId' => $category->id ?? 0]) }}" method="post">
                @csrf
                <input type="hidden" value="{{ $category->id ?? 0 }}" name="category_id">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit category</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('menu.categories') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" class="form-control" placeholder="Name" value="{{ old('name') ?? $category->name ?? '' }}" name="name">
                                        @include('components.form-feedback', ['field' => 'name'])
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
        $('form#category-form').validate({
            rules: {
                name: {
                    required: true
                }
            }
        });
    })
</script>
@endsection