@extends('layouts.app')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f5f6fa;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        background-color: white;
    }

    .login-image {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .login-image img {
        height: 60px;
    }

    .form-control,
    .form-select,
    .form-check-input {
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #1e2a38;
        border: none;
        padding: 0.5rem 1.5rem;
    }

    .btn-primary:hover {
        background-color: #141e28;
    }

    .forgot-link {
        font-size: 0.9rem;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-image">
            <img src="{{ asset('assets/AdminLTELogo.png') }}" alt="Logo">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Role --}}
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                    <option value="" {{ !old('role') ? 'selected' : '' }}>Select Role</option>
                    <option value="formateurs" {{ old('role') == 'formateurs' ? 'selected' : '' }}>Formateur</option>
                    <option value="responsables" {{ old('role') == 'responsables' ? 'selected' : '' }}>Responsable</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            {{-- Submit + Forgot --}}
            <div class="d-flex justify-content-between align-items-center">
                <a class="forgot-link" href="{{ route('password.request') }}">Forgot your password?</a>
                <button type="submit" class="btn btn-primary">LOG IN</button>
            </div>
        </form>
    </div>
</div>
@endsection
