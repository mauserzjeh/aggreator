@extends('layouts.authentication')

@section('content')

@if($errors->any())
    @foreach($errors->all() as $error)
    <p>{{$error}}</p>
    @endforeach
@endif

<div>Register</div>
<form action="{{ route('register') }}" method="post">
    @csrf
    <label>Name</label>
    <input type="text" name="name" placeholder="Name" required>
    <br>
    
    <label>Email address</label>
    <input type="email" name="email" placeholder="Email address" required>
    <br>
    
    <label>Register as</label>
    <select name="type" required>
        <option value="">Select...</option>
        @foreach(\App\Models\User::get_type_names() as $key => $value)
        <option value="{{$key}}">{{ $value }}</option>
        @endforeach
    </select>
    <br>
    
    <label>Password</label>
    <input type="password" name="password" required>
    <br>

    <label>Password confirm</label>
    <input type="password" name="password_confirmation" required>
    <br>

    <button type="submit">Register</button>
</form>
@endsection