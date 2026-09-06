<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Offers Received') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- Tabs -->
                <div class="flex gap-2 mb-6 border-b">
                    @foreach (['pending' => 'Pending', 'accepted' => 'Accepted', 'rejected' => 'Rejected', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('farmer.bids.index', ['status' => $value]) }}"
                           class="px-4 py-2 text-sm font-medium border-b-2
                               {{ $status === $value ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                @if ($bids->isEmpty())
                    <p class="text-gray-500">No offers found.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($bids as $bid)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold">{{ $bid->product->product_name }}</p>
                                        <p class="text-sm text-gray-500">from {{ $bid->buyer->full_name }}</p>
                                    </div>
                                    <span class="inline-block text-xs px-2 py-1 rounded-full
                                        @switch($bid->status)
                                            @case('pending') bg-yellow-100 text-yellow-700 @break
                                            @case('accepted') bg-green-100 text-green-700 @break
                                            @case('rejected') bg-red-100 text-red-700 @break
                                            @case('cancelled') bg-gray-100 text-gray-600 @break
                                        @endswitch">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-3 text-sm mb-2">
                                    <p>Quantity: <strong>{{ $bid->quantity }} {{ $bid->product->unit_of_measurement }}</strong></p>
                                    <p>Offered Price: <strong>₱{{ number_format($bid->offered_price, 2) }}</strong> / {{ $bid->product->unit_of_measurement }}</p>
                                    <p>Total: <strong>₱{{ number_format($bid->quantity * $bid->offered_price, 2) }}</strong></p>
                                </div>
                                <p class="text-xs text-gray-400 mb-2">Listed price: ₱{{ number_format($bid->product->selling_price, 2) }} / {{ $bid->product->unit_of_measurement }}</p>

                                @if ($bid->status === 'accepted')
                                    @if ($bid->order)
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-xs text-gray-500">Order status:</span>
                                            <span class="inline-block text-xs px-2 py-1 rounded-full
                                                @switch($bid->order->status)
                                                    @case('pending') bg-yellow-100 text-yellow-700 @break
                                                    @case('confirmed') bg-blue-100 text-blue-700 @break
                                                    @case('preparing') bg-blue-100 text-blue-700 @break
                                                    @case('ready_for_pickup') bg-purple-100 text-purple-700 @break
                                                    @case('out_for_delivery') bg-purple-100 text-purple-700 @break
                                                    @case('completed') bg-green-100 text-green-700 @break
                                                    @case('cancelled') bg-red-100 text-red-700 @break
                                                    @default bg-gray-100 text-gray-600
                                                @endswitch">
                                                {{ ucwords(str_replace('_', ' ', $bid->order->status)) }}
                                            </span>
                                            <a href="{{ route('farmer.orders.show', $bid->order_id) }}" class="text-xs text-primary-600 hover:underline">
                                                Manage Order &rarr;
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-400 mb-2 italic">Waiting for buyer to complete checkout.</p>
                                    @endif
                                @endif

                                @if ($bid->message)
                                    <p class="text-sm text-gray-600 italic mb-2">"{{ $bid->message }}"</p>
                                @endif

                                @if ($bid->status === 'pending')
                                    <div class="flex gap-2 mt-3">
                                        <form method="POST" action="{{ route('farmer.bids.accept', $bid) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-1.5 rounded-md text-sm transition">
                                                Accept Offer
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('farmer.bids.reject', $bid) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-50 font-semibold px-4 py-1.5 rounded-md text-sm">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>