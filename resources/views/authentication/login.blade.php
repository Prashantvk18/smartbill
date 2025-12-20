@include('authentication.header', ['title' => 'Login | SmartBill'])
@include('authentication.privacy-terms-modal')

<h2 class="auth-title">Welcome Back</h2>
<p class="auth-subtitle">Login to continue your journey</p>

{{-- Error Message --}}
@if (session('error'))
    <div class="error-box">
        {{ session('error') }}
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="error-box">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('login.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Unique Name</label>
        <input type="text" name="unique_name" value="{{ old('unique_name') }}" placeholder="Enter your unique name">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input @error('agree') is-invalid @enderror"
            type="checkbox"
            id="agree"
            name="agree"
            {{ old('agree') ? 'checked' : '' }}>

       <label class="form-check-label small" for="agree">
        I agree to the
            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
        and
            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Terms & Conditions</a>
        </label>

        @error('agree')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit"
        id="submitBtn"
        class="btn-primary"
        disabled>
    Login
</button>

    <!-- <button type="submit" class="btn-primary">Login</button> -->
</form>

<div class="auth-footer">
   
    <br><br>
    Don’t have an account?
    <a href="{{ route('register') }}">Register</a>
    <br>
    <a href="{{ route('forgot.password') }}"
        class="text-decoration-none small">
        Forgot Password / Username?
</a>
</div>




@include('authentication.footer')
