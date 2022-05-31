<div>
    <h1 class="text-center">Sign in</h1>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

    <x-form-card>
        <form method="POST" action="{{ route('login') }}" style="width: 22rem;">
            @csrf

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

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember" checked/>
                        <label class="form-check-label" for="remember_me"> Remember me </label>
                    </div>
                </div>

                <div class="col">
                    <!-- Simple link -->
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary mb-4">Sign in</button>
            </div>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </form>
    </x-form-card>
</div>
