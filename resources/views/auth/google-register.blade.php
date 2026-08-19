<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Welcome, {{ $name }}! Just a few more details to finish setting up your account.
    </div>

    <form method="POST" action="{{ route('google.register.store') }}">
        @csrf

        <input type="hidden" name="google_id" value="{{ $google_id }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- Role Selector -->
        <div x-data="{
                open: false,
                selected: '',
                options: { '': '-- Select --', 'buyer': 'Buyer (I want to purchase products)', 'farmer': 'Farmer (I want to sell products)' },
                select(value) { this.selected = value; this.open = false; }
             }" class="relative">
            <x-input-label for="role" value="I am registering as a:" />
            <input type="hidden" name="role" :value="selected">

            <button type="button" @click="open = !open" @click.outside="open = false"
                class="mt-1 flex justify-between items-center w-full border border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm px-3 py-2 text-left bg-white">
                <span x-text="options[selected]" class="text-gray-700"></span>
                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul x-show="open" x-cloak class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg">
                <template x-for="(label, value) in options" :key="value">
                    <li @click="select(value)"
                        :class="selected === value ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-primary-50'"
                        class="px-3 py-2 cursor-pointer text-sm"
                        x-text="label">
                    </li>
                </template>
            </ul>
            <div id="farmer-toggle" x-init="$watch('selected', value => document.getElementById('farmer-fields').style.display = value === 'farmer' ? 'block' : 'none')"></div>
        </div>

        <div class="mt-4">
            <x-input-label for="mobile_number" value="Mobile Number" />
            <x-text-input id="mobile_number" name="mobile_number" class="block mt-1 w-full" required />
        </div>

        <div class="mt-4">
            <x-input-label for="barangay" value="Barangay" />
            <x-text-input id="barangay" name="barangay" class="block mt-1 w-full" required />
        </div>

        <div id="farmer-fields" style="display:none;">
            <div class="mt-4">
                <x-input-label for="sex" value="Sex" />
                <select id="sex" name="sex" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mt-4">
                <x-input-label for="date_of_birth" value="Date of Birth" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="block mt-1 w-full" />
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>{{ __('Complete Registration') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>