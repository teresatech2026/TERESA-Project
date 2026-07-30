<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index', ['role' => $user->role]) }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to User Management
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">{{ $user->role }}</p>
                        <p class="text-lg font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500">Username: {{ $user->username }}</p>
                    </div>
                    <span class="inline-block text-xs px-2 py-1 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                @if ($user->role === 'farmer' && $user->farmer)
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <p>Mobile: <strong>{{ $user->farmer->mobile_number }}</strong></p>
                        <p>Barangay: <strong>{{ $user->farmer->barangay }}, {{ $user->farmer->municipality }}</strong></p>
                        <p>Sex: <strong>{{ $user->farmer->sex ?? '—' }}</strong></p>
                        <p>Date of Birth: <strong>{{ $user->farmer->date_of_birth?->format('M d, Y') ?? '—' }}</strong></p>
                        <p>Overall Rating: <strong>⭐ {{ number_format($user->farmer->overall_rating, 1) }} ({{ $user->farmer->total_reviews }} reviews)</strong></p>
                        <p>Completed Orders: <strong>{{ $user->farmer->completed_orders }}</strong></p>
                    </div>

                    <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2 border-t pt-4">Products ({{ $user->farmer->products->count() }})</h3>
                    @forelse ($user->farmer->products as $product)
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span>{{ $product->product_name }}</span>
                            <span class="text-gray-500">₱{{ number_format($product->selling_price, 2) }} / {{ $product->unit_of_measurement }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No products listed.</p>
                    @endforelse

                    <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2 mt-6 border-t pt-4">Orders Received ({{ $user->farmer->orders->count() }})</h3>
                    @forelse ($user->farmer->orders as $order)
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span>Order #{{ $order->id }} — {{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                            <span class="text-gray-500">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No orders yet.</p>
                    @endforelse
                @elseif ($user->role === 'buyer' && $user->buyer)
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <p>Mobile: <strong>{{ $user->buyer->mobile_number ?? '—' }}</strong></p>
                        <p>Barangay: <strong>{{ $user->buyer->barangay ?? '—' }}</strong></p>
                    </div>

                    <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2 border-t pt-4">Orders Placed ({{ $user->buyer->orders->count() }})</h3>
                    @forelse ($user->buyer->orders as $order)
                        <div class="flex justify-between text-sm py-1 border-b">
                            <span>Order #{{ $order->id }} — {{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                            <span class="text-gray-500">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No orders yet.</p>
                    @endforelse
                @endif

                <div class="border-t mt-6 pt-4">
                    <form method="POST" action="{{ route('admin.users.toggleActive', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="{{ $user->is_active ? 'border border-red-500 text-red-500 hover:bg-red-50' : 'bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white' }} font-semibold px-4 py-2 rounded-md text-sm transition">
                            {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>