<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Offers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($bids->isEmpty())
                    <p class="text-gray-500">You haven't made any offers yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($bids as $bid)
                            @php
                                $cancelMessage = 'Are you sure you want to cancel your offer of ₱' . number_format($bid->offered_price, 2) . ' for ' . $bid->product->product_name . '?';
                            @endphp
                            <div class="border rounded-lg p-4 flex gap-4">
                                @if ($bid->product->primaryImage)
                                    <img src="{{ Storage::disk('supabase')->url($bid->product->primaryImage->image_path) }}"
                                         class="w-16 h-16 object-cover rounded flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs flex-shrink-0">
                                        No Image
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-semibold">{{ $bid->product->product_name }}</p>
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
                                    <p class="text-sm text-gray-500">by {{ $bid->product->farmer->full_name }}</p>
                                    <p class="text-sm mt-1">
                                        {{ $bid->quantity }} {{ $bid->product->unit_of_measurement }} @ ₱{{ number_format($bid->offered_price, 2) }} (negotiated)
                                        = <strong>₱{{ number_format($bid->offered_total, 2) }}</strong>
                                    </p>

                                    @if ($bid->status === 'accepted')
                                        @if ($bid->order)
                                            <div class="flex items-center gap-2 mt-2">
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
                                            </div>
                                            <a href="{{ route('orders.show', $bid->order_id) }}" class="text-xs text-primary-600 hover:underline mt-1 inline-block">
                                                View Order &rarr;
                                            </a>
                                        @else
                                            <a href="{{ route('bids.checkout', $bid) }}" class="text-xs text-white bg-primary-600 hover:bg-primary-700 px-3 py-1.5 rounded-md mt-2 inline-block">
                                                Complete Order &rarr;
                                            </a>
                                        @endif
                                    @endif

                                    @if ($bid->status === 'pending')
                                        <x-confirm-action
                                            :action="route('bids.cancel', $bid)"
                                            method="PATCH"
                                            title="Cancel this offer?"
                                            :message="$cancelMessage"
                                            confirmText="Yes, Cancel Offer"
                                        >
                                            <x-slot:trigger>
                                                <button type="button" class="text-xs text-red-500 hover:underline mt-2">Cancel Offer</button>
                                            </x-slot:trigger>
                                        </x-confirm-action>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>