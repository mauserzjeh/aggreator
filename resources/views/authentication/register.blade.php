@extends('layouts.authentication')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
                <div class="text-muted text-center mt-2 mb-3">Register</div>
                <form role="form" action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="form-control" placeholder="Name" type="text" name="name">
                        </div>
                        @include('components.form-feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control" placeholder="Email" type="email" name="email">
                        </div>
                        @include('components.form-feedback', ['field' => 'email'])
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                            </div>
                            <select class="form-control" id="register-as" name="register_as">
                                <option value="" disabled selected>Register as</option>
                                @foreach(\App\Models\UserType::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @include('components.form-feedback', ['field' => 'register_as'])
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control" placeholder="Password" type="password" name="password" id="password">
                        </div>
                        @include('components.form-feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control" placeholder="Password confirmation" type="password" name="password_confirmation">
                        </div>
                        @include('components.form-feedback', ['field' => 'password_confirmation'])
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">Register</button>
                        <a href="{{ route('login') }}" class="btn btn-secondary my-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script>
    $(() => {
        $('form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                register_as: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    equalTo: '#password'
                }
            },
            submitHandler: (form) => {
                $(form).submit();
            }
        })
    });
</script>
@endsection