@extends('layouts.app')

@section('title', 'Step 3: Company Details')
@section('header', 'Tell Us About Your Company')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Step 3 of 5: Company Details</h5>
        <form action="{{ route('onboarding.step3.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $session->company_name ?? '') }}" required>
            </div>
            <div class="mb-4">
                <label for="subdomain" class="form-label">Choose Your Subdomain</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="subdomain" name="subdomain" value="{{ old('subdomain', $session->subdomain ?? '') }}" required>
                    <span class="input-group-text">.{{ config('app.domain') }}</span>
                </div>
                <div class="form-text">Lowercase letters, numbers, and dashes only.</div>
            </div>
            <div class="row g-3">
                <div class="col">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary w-100">
                        &larr; Back
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100">Continue</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
