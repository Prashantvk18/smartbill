@include('dashboard.header', ['title' => 'My Profile | CrickTeam'])

<div class="container mt-4 mb-5">

    <h4 class="fw-bold mb-3">👤 My Profile</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            Please fix the highlighted errors and try again.
        </div>
    @endif

    <div class="row g-4">

        <!-- PROFILE INFO -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">Profile Details</h6>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-2">
                            <input type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="small text-muted">Unique Username</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $user->unique_name }}"
                                   disabled>
                        </div>

                        <div class="mb-2">
                            <label class="small text-muted">Mobile Number</label>

                            <input type="text"
                                name="mobile"
                                class="form-control @error('mobile') is-invalid @enderror"
                                value="{{ old('mobile', $user->mobile) }}"
                                required>

                            @error('mobile')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                Changing mobile may affect account recovery
                            </small>
                        </div>


                        <div class="mb-3">
                            <label class="small text-muted">Date of Birth</label>
                            <input type="date" name="dob"
                                   class="form-control"
                                   value="{{ $user->dob }}">
                        </div>

                        <button class="btn btn-primary rounded-pill px-4">
                            Save Changes
                        </button>

                    </form>

                </div>
            </div>
        </div>

        <!-- CHANGE PASSWORD -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">Change Password</h6>

                    <form method="POST" action="{{ route('profile.change.password') }}">
                    @csrf

                    <div class="mb-2">
                        <label class="small text-muted">Current Password</label>
                        <input type="password"
                            name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            required>

                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="small text-muted">New Password</label>
                        <input type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted">Confirm New Password</label>
                        <input type="password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            required>

                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button class="btn btn-outline-danger rounded-pill px-4">
                        Update Password
                    </button>
                </form>


                </div>
            </div>
        </div>

    </div>

</div>

@include('dashboard.footer')
