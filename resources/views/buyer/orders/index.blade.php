<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($orders->isEmpty())
                    <p class="text-gray-500">You haven't placed any orders yet.
                        <a href="{{ route('marketplace.index') }}" class="text-primary-600 hover:underline">Browse the marketplace</a>
                    </p>
                @else
                    <div class="space-y-4">
                        @foreach ($orders as $order)
                            <a href="{{ route('orders.show', $order) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold">Order #{{ $order->id }} — {{ $order->farmer->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->items->count() }} item(s) · Placed {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">₱{{ number_format($order->total_amount, 2) }}</p>
                                        <span class="inline-block mt-1 text-xs px-2 py-1 rounded-full
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
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>