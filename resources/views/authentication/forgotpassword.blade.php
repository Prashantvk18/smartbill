@include('authentication.header', ['title' => 'Forgot Password | CrickTeam'])

<div class="auth-wrapper">

    <div class="auth-card text-center">

        <div class="auth-icon">🔐</div>

        <h4 class="fw-bold mb-2">Forgot Password or Username?</h4>

        <p class="text-muted mb-3">
            For security reasons, password and username recovery
            is handled by our support team.
        </p>

        <div class="info-box mb-3">
            Please contact SmartBill support with your
            registered mobile number for verification.
        </div>

        <a href="https://wa.me/918652897550?text=CrickTeam%20Support,%20I%20forgot%20my%20password%20or%20username.%20Registered%20mobile%20number:"
           target="_blank"
           class="btn btn-success w-100 rounded-pill mb-2">
            📲 Contact Support on WhatsApp
        </a>

        <a href="{{ route('login') }}" class="text-decoration-none small">
            ← Back to Login
        </a>

    </div>

</div>

@include('authentication.footer')
