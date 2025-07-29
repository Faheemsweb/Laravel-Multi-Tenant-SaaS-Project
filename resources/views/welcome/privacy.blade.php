@extends('layouts.layout')

@section('title', 'About')

@section('content')


  <main class="flex-shrink-0">
    <div class="container py-5">
        <div class="content-section p-5 shadow-sm">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <h1 class="mb-4">Data Privacy and Isolation</h1>
                    <p class="lead">Our commitment to data privacy is embedded in our core architecture. The SaaS application is built around a strict <strong>isolated-database multitenancy model</strong>, a design choice that fundamentally ensures the highest level of data separation.</p>
                    <h3 class="mt-4">How It Works</h3>
                    <p>This model, powered by the Spatie Multitenancy package, means that each tenant operates within its own dedicated database. There are no shared data tables or authentication layers between tenants. When a user from Tenant A logs in, their session, queries, and data operations are strictly confined to Tenant A's database. At no point can they access or even become aware of data belonging to Tenant B.</p>
                    <h3 class="mt-4">Your Data, Your Database</h3>
                    <ul>
                        <li><strong>Complete Separation:</strong> Your data is physically stored in a separate database from all other tenants.</li>
                        <li><strong>No Shared Authentication:</strong> User accounts are scoped to your specific tenant. A user in one tenant cannot authenticate into another.</li>
                        <li><strong>Controlled Access:</strong> The platform's routing and middleware ensure that all incoming requests are correctly mapped to the right tenant database, preventing any possibility of data leakage.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
