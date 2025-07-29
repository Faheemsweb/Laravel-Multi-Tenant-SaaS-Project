@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Sign In</h5>
       
<form action="{{ route('tenant.login.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
