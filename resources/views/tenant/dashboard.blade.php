@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title">Welcome, {{ $user->name }}!</h5>
        <p class="card-text">You are logged into the <strong>{{ $tenant->name }}</strong> environment.</p>
        <p class="card-text">Your domain is <strong>{{ $tenant->domain }}</strong>.</p>

        <form method="POST" action="{{ route('tenant.logout', ['tenant' => request()->route('tenant')]) }}">
    @csrf
    <button type="submit" class="btn btn-link">Logout</button>
</form>
    </div>
</div>
@endsection
