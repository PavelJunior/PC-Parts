<div>
    <h1 class="text-center">Reset Password</h1>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

    <x-form-card>
        <form method="POST" action="{{ route('password.update') }}" style="width: 22rem;">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $request->email) }}"required/>
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
                <button type="submit" class="btn btn-success mb-4">Reset Password</button>
            </div>
        </form>
    </x-form-card>
</div>

