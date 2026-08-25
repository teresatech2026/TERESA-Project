<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($cartItems->isEmpty())
                    <p class="text-gray-500">Your cart is empty.
                        <a href="{{ route('marketplace.index') }}" class="text-primary-600 hover:underline">Browse the marketplace</a>
                    </p>
                @else
                    <div class="divide-y">
                        @foreach ($cartItems as $item)
                            <div class="py-4 flex items-center gap-4">
                                @if ($item->product->primaryImage)
                                    <img src="{{ Storage::disk('supabase')->url($item->product->primaryImage->image_path) }}"
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs">
                                        No Image
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $item->product->product_name }}</h3>
                                    <p class="text-sm text-gray-500">by {{ $item->product->farmer->full_name }}</p>
                                    <p class="text-sm text-gray-500">₱{{ number_format($item->product->selling_price, 2) }} / {{ $item->product->unit_of_measurement }}</p>
                                </div>

                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="0.01" step="0.01"
                                        class="w-20 border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <button type="submit" class="text-xs text-primary-600 hover:underline">Update</button>
                                </form>

                                <p class="w-24 text-right font-medium">
                                    ₱{{ number_format($item->quantity * $item->product->selling_price, 2) }}
                                </p>

                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center border-t pt-4">
                        <p class="text-lg font-semibold">Total: ₱{{ number_format($total, 2) }}</p>
                        <a href="{{ route('checkout') }}" class="bg-accent-500 hover:bg-accent-600 text-gray-900 font-semibold px-6 py-2 rounded-md">
    Checkout
</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>