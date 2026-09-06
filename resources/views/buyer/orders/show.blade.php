<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to My Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="font-semibold">{{ $order->farmer->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->farmer->barangay }}, {{ $order->farmer->municipality }}</p>
                    </div>
                    <span class="inline-block text-xs px-2 py-1 rounded-full
                        @switch($order->status)
                            @case('pending') bg-yellow-100 text-yellow-700 @break
                            @case('confirmed') bg-blue-100 text-blue-700 @break
                            @case('preparing') bg-blue-100 text-blue-700 @break
                            @case('ready_for_pickup') bg-purple-100 text-purple-700 @break
                            @case('out_for_delivery') bg-purple-100 text-purple-700 @break
                            @case('completed') bg-green-100 text-green-700 @break
                            @case('cancelled') bg-red-100 text-red-700 @break
                            @default bg-gray-100 text-gray-600
                        @endswitch">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>

                <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Items</h3>
                <div class="divide-y mb-6">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between py-2 text-sm">
                            <span>
                                {{ $item->product_name_snapshot }} × {{ $item->quantity }}
                                <span class="text-gray-400">(₱{{ number_format($item->unit_price, 2) }} each)</span>
                            </span>
                            <span>₱{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between font-semibold border-t pt-3 mb-6">
                    <span>Total</span>
                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Delivery</h3>
                <p class="text-sm mb-1">Option: <strong>{{ ucfirst($order->delivery_option) }}</strong></p>
                @if ($order->delivery_address)
                    <p class="text-sm">Address: {{ $order->delivery_address }}</p>
                @endif

                <p class="text-xs text-gray-400 mt-6">Order placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>

                @if ($order->status === 'completed')
                    <div class="border-t mt-6 pt-6">
                        @if ($order->review)
                            <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Your Review</h3>
                            <div class="flex items-center gap-1 mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $order->review->rating ? 'text-accent-500' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                            @if ($order->review->comment)
                                <p class="text-sm text-gray-700">{{ $order->review->comment }}</p>
                            @endif
                        @else
                            <h3 class="font-semibold text-sm text-gray-500 uppercase mb-3">Leave a Review</h3>
                            <form method="POST" action="{{ route('orders.review', $order) }}" x-data="{ rating: 0, hovered: 0 }">
                                @csrf
                                <input type="hidden" name="rating" x-model="rating">

                                <div class="flex gap-1 mb-3 text-2xl">
                                    <template x-for="star in [1,2,3,4,5]" :key="star">
                                        <span @click="rating = star"
                                              @mouseenter="hovered = star"
                                              @mouseleave="hovered = 0"
                                              class="cursor-pointer"
                                              :class="(hovered || rating) >= star ? 'text-accent-500' : 'text-gray-300'">★</span>
                                    </template>
                                </div>

                                <textarea name="comment" rows="3" placeholder="Share your experience (optional)"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm mb-3"></textarea>

                                @error('rating')
                                    <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                                @enderror

                                <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                                    Submit Review
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>