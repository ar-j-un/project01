<x-guest-layout>
    <x-slot name="title">Sign In</x-slot>

    <h2 class="text-center mb-4">Sign in</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror"
                   type="email" name="email" value="{{ old('email') }}"
                   placeholder="Your email" required autofocus autocomplete="username">
            @error('email')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror"
                   type="password" name="password"
                   placeholder="Enter your password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between my-4">
            <div class="custom-control custom-checkbox">
                <input id="rememberMe" class="custom-control-input" type="checkbox" name="remember">
                <label class="custom-control-label text-dark" for="rememberMe">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="font-weight-semi-bold" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-block btn-wide btn-primary text-uppercase">Sign In</button>

        <p class="text-center mb-0 mt-4">
            Don't have an account?
            <a class="font-weight-semi-bold" href="{{ route('register') }}">Sign up here</a>
        </p>
    </form>
</x-guest-layout>