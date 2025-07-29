@extends('layouts.layout')

@section('title', 'About')

@section('content')

<main class="flex-shrink-0">
    <div class="container py-5">
        <div class="content-section p-5 shadow-sm">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <h1 class="mb-4">Platform Architecture & Terms of Use</h1>
                    <p class="lead">By using this platform, you acknowledge and agree to operate within its defined architectural boundaries. The system is divided into three clearly defined environments, each serving a distinct purpose.</p>
                    <h3 class="mt-4">The Three Environments</h3>
                    <ol>
                        <li><strong>Root Environment:</strong> This is the global context of the application. Its primary responsibilities include handling the main landing page, processing new tenant sign-ups, and managing system-wide configuration. Operations in this environment are not tenant-specific.</li>
                        <li><strong>Landlord Environment:</strong> The landlord environment is the administrative domain for managing all tenants. This is where platform administrators can view tenant status, manage subscriptions (if applicable), and perform system-wide maintenance tasks. Access to this environment is highly restricted.</li>
                        <li><strong>Tenant Environment:</strong> This is the operational space for each individual client. When you log into your provisioned subdomain, you are operating within your own tenant environment. All data, users, and activities are strictly scoped to your instance, requiring precise routing and context awareness from the platform.</li>
                    </ol>
                    <p class="mt-4">Users are expected to use the service in a manner consistent with the intended purpose of their environment. Any attempt to breach the logical separation between tenants or to access landlord-level functionality from a tenant account is a violation of these terms and will result in immediate account termination.</p>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
