<div>
    <h1 class="text-center">Register</h1>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

    <x-form-card>
        <form method="POST" action="{{ route('register') }}" style="width: 22rem;">
            @csrf

            <!-- Name input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required/>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control" required/>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required/>
            </div>

            <!-- Password Confirm input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password_confirmation">Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required/>
            </div>

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary mb-4">Register</button>
            </div>

            <!-- Register buttons -->
            <div class="text-center">
                <a href="{{ route('login') }}">Already registered?</a>
            </div>
        </form>
    </x-form-card>
</div>

