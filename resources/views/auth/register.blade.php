<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role Selector -->
        <div x-data="{
                open: false,
                selected: '{{ old('role', '') }}',
                options: {
                    '': '-- Select --',
                    'buyer': 'Buyer (I want to purchase products)',
                    'farmer': 'Farmer (I want to sell products)'
                },
                select(value) {
                    this.selected = value;
                    this.open = false;
                    toggleFarmerFields(value);
                }
             }" class="relative">
            <x-input-label for="role" :value="__('I am registering as a:')" />

            <input type="hidden" name="role" :value="selected">
            <button type="button" @click="open = !open" @click.outside="open = false"
                class="mt-1 flex justify-between items-center w-full border border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm px-3 py-2 text-left bg-white">
                <span x-text="options[selected]" class="text-gray-700"></span>
                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul x-show="open" x-cloak
                class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg">
                <template x-for="(label, value) in options" :key="value">
                    <li @click="select(value)"
                        :class="selected === value ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-primary-50'"
                        class="px-3 py-2 cursor-pointer text-sm"
                        x-text="label">
                    </li>
                </template>
            </ul>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mobile Number -->
        <div class="mt-4">
            <x-input-label for="mobile_number" :value="__('Mobile Number')" />
            <x-text-input id="mobile_number" class="block mt-1 w-full" type="text" name="mobile_number" :value="old('mobile_number')" required />
            <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
        </div>

        <!-- Barangay -->
        <div class="mt-4">
            <x-input-label for="barangay" :value="__('Barangay')" />
            <x-text-input id="barangay" class="block mt-1 w-full" type="text" name="barangay" :value="old('barangay')" required />
            <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
        </div>

        <!-- Farmer-only fields -->
        <div id="farmer-fields" style="display:none;">
            <div class="mt-4">
                <x-input-label for="sex" :value="__('Sex')" />
                <select id="sex" name="sex" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full pr-10 border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" />
                <button type="button" onclick="togglePassword('password', 'password-eye')"
                    class="absolute top-1/2 right-3 -translate-y-1/2">
                    <svg id="password-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full pr-10 border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" />
                <button type="button" onclick="togglePassword('password_confirmation', 'confirm-eye')"
                    class="absolute top-1/2 right-3 -translate-y-1/2">
                    <svg id="confirm-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
    function toggleFarmerFields(role) {
        const farmerFields = document.getElementById('farmer-fields');
        farmerFields.style.display = (role === 'farmer') ? 'block' : 'none';
    }
    toggleFarmerFields('{{ old('role', '') }}');

    function togglePassword(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);

        if (input.type === 'password') {
            input.type = 'text';
            eye.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;
        } else {
            input.type = 'password';
            eye.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
    </script>
</x-guest-layout>