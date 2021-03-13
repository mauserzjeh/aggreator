@extends('layouts.application')
@section('title', 'Profile')
@section('content')
<div class="container-fluid mt-6">
    <div class="row">
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="profile-info-form" role="form" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" class="form-control" placeholder="Name" value="{{ old('name') ?? $user->name }}" name="name">
                                        @include('components.form-feedback', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email" class="form-control" placeholder="Email address" value="{{ old('email') ?? $user->email }}" name="email">
                                        @include('components.form-feedback', ['field' => 'email'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h6 class="heading-small text-muted mb-4">Password</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-old-password">Old password</label>
                                        <input type="password" id="input-old-password" class="form-control" value="" name="old_password">
                                        @include('components.form-feedback', ['field' => 'old_password'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-new-password">New password</label>
                                        <input type="password" id="input-new-password" class="form-control" value="" name="password">
                                        @include('components.form-feedback', ['field' => 'password'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-new-password-confirmation">New password confirmation</label>
                                        <input type="password" id="input-new-password-confirmation" class="form-control" value="" name="password_confirmation">
                                        @include('components.form-feedback', ['field' => 'password_confirmation'])
                                    </div>
                                </div>
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
        $('form#profile-info-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                old_password: {
                    pair: '#input-new-password' 
                },
                password: {
                    minlength: 8,
                    pair: '#input-old-password'
                },
                password_confirmation: {
                    equalTo: '#input-new-password'
                }
            },
            messages: {
                old_password: {
                    pair: 'The password is required'
                },
                password: {
                    pair: 'The old password is also required'
                },
            }
        });
    });
</script>
@endsection