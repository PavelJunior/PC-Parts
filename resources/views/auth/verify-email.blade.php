<div>
    <h1 class="text-center">Thanks for signing up!</h1>
    <p class="text-center">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</p>

    @if (session('status') == 'verification-link-sent')
        <p class="mb-4 text-cente">
            A new verification link has been sent to the email address you provided during registration.
        </p>
    @endif

    <x-form-card>
        <form method="POST" action="{{ route('verification.send') }}" style="width: 22rem;">
            @csrf

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary mb-4">Resend Verification Email</button>
            </div>
        </form>

        <form method="GET" action="{{ route('logout') }}" style="width: 22rem;">
            @csrf

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary mb-4">Log Out</button>
            </div>
        </form>
    </x-form-card>
</div>
