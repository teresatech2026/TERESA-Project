<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    @foreach ($groupedByFarmer as $farmerId => $items)
                        <div class="border rounded-lg p-4 mb-6">
                            <h3 class="font-semibold mb-3">Order from {{ $items->first()->product->farmer->full_name }}</h3>

                            @foreach ($items as $item)
                                <div class="flex justify-between text-sm py-1">
                                    <span>{{ $item->product->product_name }} × {{ $item->quantity }} {{ $item->product->unit_of_measurement }}</span>
                                    <span>₱{{ number_format($item->quantity * $item->product->selling_price, 2) }}</span>
                                </div>
                            @endforeach

                            <div class="flex justify-between font-medium border-t mt-2 pt-2">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($items->sum(fn($i) => $i->quantity * $i->product->selling_price), 2) }}</span>
                            </div>
                        </div>
                    @endforeach

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
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>