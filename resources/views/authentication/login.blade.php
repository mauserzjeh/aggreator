@extends('layouts.authentication')

@section('content')
<div>Login</div>
<form action="{{ route('login.submit') }}" method="post">
    @csrf
    <label>Email</label>
    <input type="email" name="email" placeholder="Email address" required>
    <br>

    <label>Password</label>
    <input type="password" name="password" required>
    <br>

    <button type="submit">Login</button>
</form>
@endsection