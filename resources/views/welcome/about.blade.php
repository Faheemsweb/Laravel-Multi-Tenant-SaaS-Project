@extends('layouts.layout')

@section('title', 'About')

@section('content')


    <main class="flex-shrink-0">
        <div class="container py-5">
            <div class="content-section p-5 shadow-sm">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <h1 class="mb-4">Project Objective</h1>
                        <p class="lead">The primary objective of this project is to implement a structured, environment-aware onboarding and provisioning flow for new tenants within our multi-tenant SaaS platform.</p>
                        <p>Developers are tasked with creating a seamless experience that guides a new user through the sign-up process, validates their information, and automatically provisions their dedicated, isolated environment. This includes creating a new database for the tenant, migrating the necessary schema, and establishing the initial user account.</p>
                        <p>A key requirement is to adhere to a clean separation of logic across our multiple runtime environments. The system must intelligently route requests and scope operations correctly, ensuring that actions intended for the "landlord" environment do not bleed into a specific "tenant" environment, and vice-versa.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
