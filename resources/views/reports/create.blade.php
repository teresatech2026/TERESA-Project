<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report') }} {{ $reportedUser->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('reports.store', $reportedUser) }}">
                    @csrf

                    <div class="mb-4" x-data="{
                            open: false,
                            selected: '{{ old('reason', '') }}',
                            options: {
                                '': '-- Select a reason --',
                                'Scam or fraud': 'Scam or fraud',
                                'No-show / failed to deliver': 'No-show / failed to deliver',
                                'Harassment or abusive behavior': 'Harassment or abusive behavior',
                                'Misleading product listing': 'Misleading product listing',
                                'Payment issue': 'Payment issue',
                                'Other': 'Other'
                            }
                         }">
                        <x-input-label for="reason" value="Reason" />

                        <div class="relative">
                            <input type="hidden" name="reason" :value="selected">

                            <button type="button" @click="open = !open" @click.outside="open = false"
                                class="mt-1 flex justify-between items-center w-full border border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm px-3 py-2 text-left bg-white">
                                <span x-text="options[selected]" class="text-gray-700"></span>
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <ul x-show="open" x-cloak
    class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-40 overflow-y-auto">
                                <template x-for="(label, value) in options" :key="value">
                                    <li @click="selected = value; open = false"
                                        :class="selected === value ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-primary-50'"
                                        class="px-3 py-2 cursor-pointer text-sm"
                                        x-text="label">
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="details" value="Additional Details (optional)" />
                        <textarea id="details" name="details" rows="4"
                            class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                            placeholder="Please describe what happened..."></textarea>
                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                    </div>

                    <div class="flex justify-end items-center gap-3">
                        <a href="{{ url()->previous() }}"
                           class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-semibold">
                            Cancel
                        </a>
                        <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>