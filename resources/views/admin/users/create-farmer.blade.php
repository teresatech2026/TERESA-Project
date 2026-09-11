<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register a Farmer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-6">
                    Fill in the details as provided by the farmer, including the password they've chosen for their own account.
                </p>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store-farmer') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" name="name" class="block mt-1 w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="mobile_number" value="Mobile Number" />
                        <x-text-input id="mobile_number" name="mobile_number" class="block mt-1 w-full" :value="old('mobile_number')" required />
                        <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="barangay" value="Barangay" />
                        <x-text-input id="barangay" name="barangay" class="block mt-1 w-full" :value="old('barangay')" required />
                        <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="rsbsa_number" value="RSBSA Number (optional)" />
                        <x-text-input id="rsbsa_number" name="rsbsa_number" class="block mt-1 w-full" :value="old('rsbsa_number')" placeholder="Leave blank if not yet registered with RSBSA" />
                        <x-input-error :messages="$errors->get('rsbsa_number')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="sex" value="Sex" />
                            <select id="sex" name="sex" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">-- Select --</option>
                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="date_of_birth" value="Date of Birth" />
                            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="block mt-1 w-full" :value="old('date_of_birth')" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" value="Password (chosen by the farmer)" />
                        <div class="relative mt-1">
                            <input id="password" type="password" name="password" required
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

                    <div class="mb-6">
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <div class="relative mt-1">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="block w-full pr-10 border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" />
                            <button type="button" onclick="togglePassword('password_confirmation', 'password-confirmation-eye')"
                                class="absolute top-1/2 right-3 -translate-y-1/2">
                                <svg id="password-confirmation-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index', ['role' => 'farmer']) }}"
                           class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-semibold">
                            Cancel
                        </a>
                        <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                            Register Farmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
</x-app-layout>