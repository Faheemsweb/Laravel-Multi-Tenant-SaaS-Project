@extends('layouts.app')

@section('title', 'Provisioning Your Account')
@section('header', 'We are setting things up!')

@section('content')
<div class="card shadow-sm text-center">
    <div class="card-body p-5">
        <div class="spinner-border text-primary mb-4" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="card-title">Your account is being provisioned.</h5>
        <p class="text-muted">This may take a minute or two. Please do not close this page.</p>
        <p>Once complete, you will be able to access your dashboard at:</p>
        <p>
            <a href="#" id="tenant-link" class="fs-5 fw-bold">{{ $domain }}</a>
        </p>
        <p class="mt-4">We'll automatically redirect you when it's ready.</p>
    </div>
</div>

<script>
    const tenantUrl = 'http://{{ $domain }}';
    const interval = setInterval(() => {
        fetch(tenantUrl, { method: 'HEAD', mode: 'no-cors' })
            .then(response => {
                clearInterval(interval);
                window.location.href = tenantUrl;
            })
            .catch(err => {
                console.log('Pinging tenant... not ready yet.');
            });
    }, 5000);
</script>
@endsection
