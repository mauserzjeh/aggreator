@if($errors->has($field))
    <div class="invalid-feedback form-feedback">
        {{ $errors->first($field) }}
    </div>
@endif