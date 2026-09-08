<x-guest-layout>
    <x-slot name="title">Create Account</x-slot>

    <h2 class="text-center mb-4">Create account</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full name</label>
            <input id="name" class="form-control @error('name') is-invalid @enderror"
                   type="text" name="name" value="{{ old('name') }}"
                   placeholder="Your full name" required autofocus autocomplete="name">
            @error('name')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Your email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror"
                   type="email" name="email" value="{{ old('email') }}"
                   placeholder="Your email" required autocomplete="username">
            @error('email')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror"
                   type="password" name="password"
                   placeholder="Enter your password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                   type="password" name="password_confirmation"
                   placeholder="Confirm your password" required autocomplete="new-password">
            @error('password_confirmation')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="custom-control custom-checkbox my-4">
            <input id="agreement" class="custom-control-input" type="checkbox" required>
            <label class="custom-control-label text-dark" for="agreement">I agree with terms &amp; conditions</label>
        </div>

        <button type="submit" class="btn btn-block btn-wide btn-primary text-uppercase">Sign Up</button>

        <p class="text-center mb-0 mt-4">
            Already have an account?
            <a class="font-weight-semi-bold" href="{{ route('login') }}">Login here</a>
        </p>
    </form>
</x-guest-layout>