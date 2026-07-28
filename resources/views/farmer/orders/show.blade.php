<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('farmer.orders.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to Incoming Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-semibold text-sm text-gray-500 uppercase mb-1">Buyer</h3>
                        <p class="font-medium">{{ $order->buyer->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->buyer->mobile_number }}</p>
                        <p class="text-sm text-gray-500">{{ $order->buyer->barangay }}</p>
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
                            <span>{{ $item->product_name_snapshot }} × {{ $item->quantity }}</span>
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
                    <p class="text-sm mb-6">Address: {{ $order->delivery_address }}</p>
                @else
                    <p class="text-sm mb-6"></p>
                @endif

                <!-- Status Update Controls -->
                @if (!in_array($order->status, ['completed', 'cancelled']))
                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-sm text-gray-500 uppercase mb-3">Update Order Status</h3>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $nextSteps = match($order->status) {
                                    'pending' => ['confirmed' => 'Confirm Order'],
                                    'confirmed' => ['preparing' => 'Mark as Preparing'],
                                    'preparing' => $order->delivery_option === 'delivery'
                                        ? ['out_for_delivery' => 'Out for Delivery']
                                        : ['ready_for_pickup' => 'Ready for Pickup'],
                                    'ready_for_pickup' => ['completed' => 'Mark as Completed'],
                                    'out_for_delivery' => ['completed' => 'Mark as Completed'],
                                    default => [],
                                };
                            @endphp

                            @foreach ($nextSteps as $value => $label)
                                <form method="POST" action="{{ route('farmer.orders.updateStatus', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $value }}">
                                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-md text-sm">
                                        {{ $label }}
                                    </button>
                                </form>
                            @endforeach

                            <form method="POST" action="{{ route('farmer.orders.updateStatus', $order) }}"
                                  onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 font-semibold px-4 py-2 rounded-md text-sm">
                                    Cancel Order
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <p class="text-xs text-gray-400 mt-6">Order placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>