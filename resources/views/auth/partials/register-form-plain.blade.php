<form method="POST" action="{{ route('register') }}" x-data="{ showPassword: false, showConfirm: false }">
    @csrf

    <div class="auth-field">
        <label for="modal_name">Full Name</label>
        <input id="modal_name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <div class="auth-field">
        <label for="modal_reg_email">Email</label>
        <input id="modal_reg_email" type="email" name="email" value="{{ old('email') }}" autocomplete="username">
        @error('email') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <div class="auth-field">
        <label for="modal_mobile">Mobile Number</label>
        <input id="modal_mobile" type="text" name="mobile_number" value="{{ old('mobile_number') }}" required>
        @error('mobile_number') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <div class="auth-field">
        <label for="modal_barangay">Barangay</label>
        <input id="modal_barangay" type="text" name="barangay" value="{{ old('barangay') }}" required>
        @error('barangay') <p class="auth-error">{{ $message }}</p> @enderror
    </div>

    <div class="auth-field">
        <label for="modal_reg_password">Password</label>
        <div class="auth-pass-wrap">
            <input :type="showPassword ? 'text' : 'password'" id="modal_reg_password" name="password" required autocomplete="new-password">
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

    <div class="auth-field">
        <label for="modal_reg_password_confirmation">Confirm Password</label>
        <div class="auth-pass-wrap">
            <input :type="showConfirm ? 'text' : 'password'" id="modal_reg_password_confirmation" name="password_confirmation" required autocomplete="new-password">
            <button type="button" @click="showConfirm = !showConfirm">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#5b6b5c" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!showConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path x-show="!showConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    <path x-show="showConfirm" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-primary auth-submit">Register</button>
</form>