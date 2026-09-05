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
                        <x-input-label for="email" value="Email (optional)" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email')" />
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
                        <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" required />
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
</x-app-layout>