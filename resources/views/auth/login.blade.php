@extends('layouts.login')

@section('content')
    <div class="login-container">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-form">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-form mt-2">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-form mt-3">
                <div class="d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    {{-- @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif --}}
                </div>
            </div>

            <button type="submit" class="primary-button w-100 mt-3">
                {{ __('Login') }}
            </button>
        </form>
    </div>
@endsection
