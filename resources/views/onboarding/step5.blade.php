@extends('layouts.app')

@section('title', 'Step 5: Confirmation')
@section('header', 'Confirm Your Details')

@section('content')

<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Step 5 of 5: Confirmation</h5>
        <p class="text-center">Please review your information before we create your account.</p>

        <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item"><strong>Full Name:</strong> {{ $session->full_name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $session->email }}</li>
            <li class="list-group-item"><strong>Company:</strong> {{ $session->company_name }}</li>
            <li class="list-group-item"><strong>Subdomain:</strong> {{ $session->subdomain }}.{{ config('app.domain') }}</li>
            <li class="list-group-item"><strong>Billing Name:</strong> {{ $session->billing_name }}</li>
        </ul>

        <form action="{{ route('onboarding.step5.store') }}" method="POST">
            @csrf
            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">Confirm & Provision Account</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <a href="javascript:history.back()" class="btn btn-outline-secondary w-100">
                &larr; Back
            </a>
        </div>
    </div>
</div>
@endsection
