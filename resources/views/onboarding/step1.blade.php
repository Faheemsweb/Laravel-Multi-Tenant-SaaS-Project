@extends('layouts.app')

@section('title', 'Step 1: Account Information')
@section('header', 'Create Your Account')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Step 1 of 5: Account Information</h5>
        <form action="{{ route('onboarding.step1.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $session->full_name ?? '') }}" required>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $session->email ?? '') }}" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Continue</button>
            </div>
        </form>
    </div>
</div>
@endsection
