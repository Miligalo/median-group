@extends('layouts.app')

@section('content')

<header class="header">
    <div class="container">
        <div class="header__inner">
            <a href="/" class="header__logo">Median Group</a>
        </div>
    </div>
</header>

<section class="hero">
    <div class="container">
        <span class="hero__badge">Business Solutions</span>
        <h1 class="hero__title">
            Grow your business<br>with <span>smart tools</span>
        </h1>
        <p class="hero__subtitle">
            We help companies scale faster with modern technology, expert consulting, and tailored strategies.
        </p>

        <div class="features">
            <div class="feature-card">
                <div class="feature-card__icon">🚀</div>
                <div class="feature-card__title">Fast Onboarding</div>
                <div class="feature-card__text">Get started in minutes. No complex setup required.</div>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">📊</div>
                <div class="feature-card__title">Real-time Analytics</div>
                <div class="feature-card__text">Track performance and make data-driven decisions.</div>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">🤝</div>
                <div class="feature-card__title">Dedicated Support</div>
                <div class="feature-card__text">Our team is available to help you every step of the way.</div>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">🔒</div>
                <div class="feature-card__title">Secure & Reliable</div>
                <div class="feature-card__text">Enterprise-grade security you can rely on.</div>
            </div>
        </div>
    </div>
</section>

<section class="form-section section--alt">
    <div class="container">
        <div class="form-section__heading">
            <h2 class="form-section__title">Get in touch</h2>
            <p class="form-section__subtitle">Leave your details and we'll reach out within 24 hours.</p>
        </div>
        @livewire('lead-form')
    </div>
</section>

<footer class="footer">
    <div class="container">
        &copy; {{ date('Y') }} Median Group. All rights reserved.
    </div>
</footer>

@endsection
