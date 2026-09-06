<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Your Negotiated Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('bids.checkout.store', $bid) }}">
                    @csrf

                    <div class="border rounded-lg p-4 mb-6">
                        <h3 class="font-semibold mb-3">Order from {{ $bid->product->farmer->full_name }}</h3>

                        <div class="flex justify-between text-sm py-1">
                            <span>
                                {{ $bid->product->product_name }} × {{ $bid->quantity }} {{ $bid->product->unit_of_measurement }}
                                <span class="text-gray-400">(₱{{ number_format($bid->offered_price, 2) }} each, negotiated)</span>
                            </span>
                            <span>₱{{ number_format($bid->offered_total, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 mt-1">
                            Listed price was ₱{{ number_format($bid->product->selling_price, 2) }} — this order uses your accepted offer instead.
                        </p>

                        <div class="flex justify-between font-medium border-t mt-2 pt-2">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($bid->offered_total, 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <h3 class="font-semibold mb-2">Delivery Option</h3>
                        <label class="flex items-center gap-2 mb-2">
                            <input type="radio" name="delivery_option" value="pickup" checked
                                   class="text-primary-600 focus:ring-primary-500" onchange="document.getElementById('address-field').style.display='none'">
                            <span>Pickup</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="delivery_option" value="delivery"
                                   class="text-primary-600 focus:ring-primary-500" onchange="document.getElementById('address-field').style.display='block'">
                            <span>Delivery</span>
                        </label>

                        <div id="address-field" style="display:none;" class="mt-3">
                            <x-input-label for="delivery_address" value="Delivery Address" />
                            <textarea id="delivery_address" name="delivery_address" rows="2"
                                class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"></textarea>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-3 rounded-md">
                        Confirm & Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>