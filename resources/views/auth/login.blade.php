@extends('layouts.app')

@section('content')
<div class="container" style="background-color: #F0F9FF; min-height: 100vh; padding-top: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-header text-center" style="background-color: #00C9A7; color: white;">
                    <h4 class="mb-0">Welcome Back</h4>
                    <small>Please sign in to your account</small>
                </div>

                <div class="card-body px-4 py-4">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="you@example.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password with show/hide -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor:pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary" style="background-color: #00C9A7; border: none;">
                                🔐 Login
                            </button>

                            @if (Route::has('password.request'))
                            <a class="text-decoration-none text-muted" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password toggle script -->
@push('scripts')
<script>
    function togglePassword(fieldId, el) {
        var input = document.getElementById(fieldId);
        var icon = el.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush

@endsection