<form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
    @csrf

    <div class="auth-field">
        <label for="modal_email">Email</label>
        <input id="modal_email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <div class="auth-field">
        <label for="modal_password">Password</label>
        <div class="auth-pass-wrap">
            <input :type="showPassword ? 'text' : 'password'" id="modal_password" name="password" required autocomplete="current-password">
            <button type="button" @click="showPassword = !showPassword">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#5b6b5c" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    <path x-show="showPassword" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
            </button>
        </div>
        @error('password') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <label class="auth-remember">
        <input type="checkbox" name="remember">
        Remember me
    </label>

    <button type="submit" class="btn-primary auth-submit">Log in</button>

    @if (Route::has('password.request'))
        <div style="text-align:right; margin-top:10px;">
            <a href="{{ route('password.request') }}" style="font-size:12.5px; color:var(--ink-soft); text-decoration:underline;">Forgot your password?</a>
        </div>
    @endif
</form>

<div class="auth-divider">or</div>

<a href="{{ route('google.redirect') }}" class="auth-google-btn">
    <svg style="width:18px;height:18px" viewBox="0 0 24 24">
        <path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.63h6.47a5.53 5.53 0 01-2.4 3.63v3h3.87c2.27-2.09 3.58-5.17 3.58-8.81z"/>
        <path fill="#34A853" d="M12 24c3.24 0 5.96-1.07 7.94-2.92l-3.87-3c-1.08.72-2.45 1.15-4.07 1.15-3.13 0-5.78-2.11-6.73-4.95H1.27v3.1A12 12 0 0012 24z"/>
        <path fill="#FBBC05" d="M5.27 14.28A7.2 7.2 0 014.9 12c0-.79.14-1.56.37-2.28v-3.1H1.27A12 12 0 000 12c0 1.94.46 3.77 1.27 5.38l4-3.1z"/>
        <path fill="#EA4335" d="M12 4.77c1.77 0 3.35.61 4.6 1.8l3.43-3.43C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.27 6.62l4 3.1C6.22 6.88 8.87 4.77 12 4.77z"/>
    </svg>
    Sign in with Google
</a>