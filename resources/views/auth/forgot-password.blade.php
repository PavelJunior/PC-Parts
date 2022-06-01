<div>
    <h1 class="text-center">Want to reset password?</h1>
    <p class="text-center">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

    <x-form-card>
        <form method="POST" action="{{ route('password.email') }}" style="width: 22rem;">
            @csrf

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control" required/>
            </div>

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success mb-4">Email Password Reset Link</button>
            </div>
        </form>
    </x-form-card>
</div>
