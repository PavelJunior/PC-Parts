<div>
    <h1 class="text-center">Confirm Password</h1>
    <p class="text-center">This is a secure area of the application. Please confirm your password before continuing.</p>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

    <x-form-card>
        <form method="POST" action="{{ route('password.confirm') }}" style="width: 22rem;">
            @csrf

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Email address</label>
                <input type="password" name="password" id="password" class="form-control" required/>
            </div>

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success mb-4">Confirm</button>
            </div>
        </form>
    </x-form-card>
</div>
