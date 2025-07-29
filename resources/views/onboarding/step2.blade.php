@extends('layouts.app')

@section('title', 'Step 2: Password Setup')
@section('header', 'Secure Your Account')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-5">
        <h5 class="card-title text-center mb-4">Step 2 of 5: Password Setup</h5>
        <form action="{{ route('onboarding.step2.store') }}" method="POST" id="password-setup-form">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="form-text">Minimum 8 characters, with uppercase, lowercase, numbers, and symbols.</div>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
<script>
    // Reset form when the page is shown from the browser cache (like clicking Back)
    window.addEventListener("pageshow", function(event) {
        const form = document.getElementById("password-setup-form");
        if (form) {
            form.reset();
        }
    });
</script>


@endsection
