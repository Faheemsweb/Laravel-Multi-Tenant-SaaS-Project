@extends('layouts.layout')

@section('title', 'Welcome')

@section('content')

 <header>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('includes/images/image 2.jpg') }}')">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Structured Tenant Onboarding.</h1>
                        <p>Implementing an environment-aware provisioning flow for new tenants.</p>
                        <p><a class="btn btn-lg btn-primary" href="{{ route('onboarding.step1.show') }}">Begin Provisioning</a></p>
                    </div>
                </div>
            </div>

            <div class="carousel-item" style="background-image: url('{{ asset('includes/images/silder2.jpg') }}')">
                <div class="container">
                    <div class="carousel-caption ">
                        <h1>Clean Separation of Logic.</h1>
                        <p>Precise routing and scoping behavior across all environments.</p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
    </div>
</header>

<main class="flex-shrink-0">
    <div class="container py-5">
        <div class="content-section p-5 shadow-sm">
            <div class="row"><div class="col-lg-10 mx-auto text-center">
                <h2 class="mb-4">Evaluation Task Overview</h2>
                <p class="lead">This document outlines the evaluation task for full-stack developers contributing to a multi-tenant SaaS platform built on Laravel. The objective is to implement a structured, environment-aware onboarding and provisioning flow for new tenants, while adhering to clean separation of logic across multiple runtime environments.</p>
                <p>The SaaS application is architected around a strict isolated-database multitenancy model, powered by the Spatie Multitenancy package. Each tenant operates within its own database, with no shared data or authentication layers. The platform is divided into three clearly defined environments—root, landlord, and tenant—each serving a distinct purpose, and each requiring precise routing and scoping behavior.</p>
            </div></div>
        </div>
    </div>
</main>

@endsection
