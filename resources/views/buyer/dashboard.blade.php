<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buyer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome, {{ auth()->user()->name }}!
                    <br><br>
                    <div class="flex gap-3">
                        <a href="{{ route('marketplace.index') }}"
                           class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-md text-sm">
                            Browse Marketplace
                        </a>
                        <a href="{{ route('cart.index') }}"
                           class="inline-block border border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold px-4 py-2 rounded-md text-sm">
                            My Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>