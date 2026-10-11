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

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($cartItems->isEmpty())
                    <p class="text-gray-500">Your cart is empty.
                        <a href="{{ route('marketplace.index') }}" class="text-primary-600 hover:underline">Browse the marketplace</a>
                    </p>
                @else
                    {{-- Checkout form: the checkboxes below are linked to it with form="checkout-form" --}}
                    <form id="checkout-form" method="GET" action="{{ route('checkout') }}">
                        <input type="hidden" name="selecting" value="1">
                    </form>

                    {{-- Select all --}}
                    <label class="flex items-center gap-3 pb-3 border-b cursor-pointer select-none">
                        <input type="checkbox" id="select-all" checked
                               class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm font-medium text-gray-700">Select all</span>
                    </label>

                    <div class="divide-y">
                        @foreach ($cartItems as $item)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">

                                {{-- Checkbox + image + product info --}}
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}" form="checkout-form" checked
                                           data-amount="{{ $item->quantity * $item->product->selling_price }}"
                                           class="item-checkbox h-5 w-5 flex-shrink-0 rounded border-gray-300 text-primary-600 focus:ring-primary-500">

                                    @if ($item->product->primaryImage)
                                        <img src="{{ Storage::disk('supabase')->url($item->product->primaryImage->image_path) }}"
                                             class="w-20 h-20 object-cover rounded flex-shrink-0">
                                    @else
                                        <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs flex-shrink-0">
                                            No Image
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <h3 class="font-semibold">{{ $item->product->product_name }}</h3>
                                        <p class="text-sm text-gray-500">by {{ $item->product->farmer->full_name }}</p>
                                        <p class="text-sm text-gray-500">₱{{ number_format($item->product->selling_price, 2) }} / {{ $item->product->unit_of_measurement }}</p>
                                    </div>
                                </div>

                                {{-- Quantity, subtotal, remove --}}
                                <div class="flex items-center justify-between sm:justify-end gap-3">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="0.01" step="0.01"
                                            class="w-20 border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                        <button type="submit" class="text-xs text-primary-600 hover:underline">Update</button>
                                    </form>

                                    <p class="sm:w-24 text-right font-medium whitespace-nowrap">
                                        ₱{{ number_format($item->quantity * $item->product->selling_price, 2) }}
                                    </p>

                                    <x-confirm-action
                                        :action="route('cart.destroy', $item)"
                                        method="DELETE"
                                        title="Remove item?"
                                        :message="'Are you sure you want to remove ' . $item->product->product_name . ' from your cart?'"
                                        confirmText="Yes, Remove"
                                    >
                                        <x-slot:trigger>
                                            <button type="button" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                                        </x-slot:trigger>
                                    </x-confirm-action>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center border-t pt-4 gap-3">
                        <div>
                            <p class="text-xs text-gray-500"><span id="selected-count">0</span> selected</p>
                            <p class="text-lg font-semibold">Total: <span id="selected-total">₱0.00</span></p>
                        </div>
                        <button type="submit" form="checkout-form" id="checkout-btn"
                                class="bg-accent-500 hover:bg-accent-600 text-gray-900 font-semibold px-6 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                            Checkout
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        (function () {
            const selectAll = document.getElementById('select-all');
            const boxes = Array.from(document.querySelectorAll('.item-checkbox'));
            const countEl = document.getElementById('selected-count');
            const totalEl = document.getElementById('selected-total');
            const checkoutBtn = document.getElementById('checkout-btn');

            if (!selectAll || boxes.length === 0) return;

            function refresh() {
                const checked = boxes.filter(b => b.checked);
                const total = checked.reduce((sum, b) => sum + parseFloat(b.dataset.amount), 0);

                countEl.textContent = checked.length;
                totalEl.textContent = '₱' + total.toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                checkoutBtn.disabled = checked.length === 0;
                selectAll.checked = checked.length === boxes.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < boxes.length;
            }

            selectAll.addEventListener('change', function () {
                boxes.forEach(b => b.checked = selectAll.checked);
                refresh();
            });

            boxes.forEach(b => b.addEventListener('change', refresh));
            refresh();
        })();
    </script>
</x-app-layout>