@include('authentication.header', ['title' => 'Register | SmartBill'])
@include('authentication.privacy-terms-modal')

<h2 class="auth-title">SmartBill Registration</h2>
<p class="auth-subtitle">Start your journey </p>

@if ($errors->any())
    <div class="error-box">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>User Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div class="form-group">
        <label>Unique Name</label>
        <input type="text" name="unique_name" value="{{ old('unique_name') }}">
    </div>

    <div class="form-group">
        <label>Mobile Number</label>
        <input type="text" name="mobile" value="{{ old('mobile') }}">
    </div>

    <div class="form-group">
        <label>Date of Birth</label>
        <input type="date" name="dob" value="{{ old('dob') }}">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password">
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
    <!-- <button type="submit" class="btn-primary">Register</button> -->
    <button type="submit" id="submitBtn" class="btn-primary" disabled>
        Register
    </button>

</form>

<div class="auth-footer">
    Already have an account?
    <a href="{{ route('login') }}">Login</a>
</div>


<script>
document.getElementById('agree').addEventListener('change', function () {
    document.getElementById('submitBtn').disabled = !this.checked;
});

function openPrivacyModal() {
    new bootstrap.Modal(
        document.getElementById('privacyTermsModal')
    ).show();
}
</script>


@include('authentication.footer')
