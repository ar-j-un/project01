<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-group">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted small mb-1">
                    Your email address is unverified.
                    <button form="send-verification" type="submit" class="btn btn-link p-0 font-weight-semi-bold"
                        style="font-size: inherit;">
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="text-success small mb-0">A new verification link has been sent to your email address.</p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center mt-4">
        <button type="submit" class="btn btn-primary text-uppercase">Save</button>

        @if (session('status') === 'profile-updated')
            <span class="text-success ml-3">Saved.</span>
        @endif
    </div>
</form>