@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-teal text-warning fw-semibold">
                <i class="fas fa-key me-1 text-warning"></i> Reset Password
            </div>
            <div class="card-body">

                <p class="text-muted mb-4">
                    Forgot your password? No problem. Enter your email and we'll send a password reset link.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                         <div class="card-header text-center" style="background-color: #00C9A7; color: white;">
                            <i class="fas fa-envelope me-1"></i> Send Password Reset Link
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
