<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Market Analytics & Advisories') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.advisories.create') }}"
                   class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                    + Add Advisory
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Market Overview -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Market Overview</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['total_products'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Active Products</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['total_farmers'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Registered Farmers</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['total_orders'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Orders</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['completed_orders'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Completed Orders</p>
                    </div>
                </div>
            </div>

            <!-- Demand Insights -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Most Ordered Commodities</h3>
                    @if ($mostOrdered->isEmpty())
                        <p class="text-gray-400 text-sm">No order data yet.</p>
                    @else
                        <canvas id="mostOrderedChart" height="200"></canvas>
                    @endif
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">High Demand Commodities</h3>
                    @forelse ($highDemand as $item)
                        <div class="flex justify-between text-sm py-2 border-b last:border-0">
                            <span>{{ $item->commodity_type }}</span>
                            <span class="text-gray-500">{{ $item->order_count }} orders</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No order data yet.</p>
                    @endforelse
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Low Demand Products</h3>
                    <p class="text-xs text-gray-400 mb-2">Active listings with no orders yet</p>
                    @forelse ($lowDemand as $product)
                        <div class="flex justify-between text-sm py-2 border-b last:border-0">
                            <span>{{ $product->product_name }}</span>
                            <span class="text-gray-500">{{ $product->commodity_type }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">All active products have at least one order.</p>
                    @endforelse
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Monthly Demand Trend</h3>
                    <p class="text-xs text-gray-400 mb-2">Total quantity ordered per month (last 6 months)</p>
                    @if ($monthlyTrend->isEmpty())
                        <p class="text-gray-400 text-sm">No trend data yet.</p>
                    @else
                        <canvas id="monthlyTrendChart" height="200"></canvas>
                    @endif
                </div>
            </div>

            <!-- Agricultural Advisories -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Agricultural Advisories</h3>

                @if ($advisories->isEmpty())
                    <p class="text-gray-400 text-sm">No advisories published yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($advisories as $advisory)
                            <div class="border-b pb-6 last:border-0">
                                @if ($advisory->image_path)
                                    <img src="{{ Storage::url($advisory->image_path) }}" class="w-full max-h-64 object-cover rounded-lg mb-3">
                                @endif
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold">{{ $advisory->title }}</h4>
                                        @if ($advisory->category)
                                            <span class="inline-block text-xs px-2 py-1 rounded-full bg-primary-50 text-primary-600 mt-1">
                                                {{ $advisory->category }}
                                            </span>
                                        @endif
                                    </div>
                                    @if (auth()->user()->role === 'admin')
                                        <form method="POST" action="{{ route('admin.advisories.destroy', $advisory) }}"
                                              onsubmit="return confirm('Delete this advisory?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                                        </form>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 mt-2">{{ $advisory->content }}</p>
                                <p class="text-xs text-gray-400 mt-3">
                                    Prepared by <strong>{{ $advisory->prepared_by }}</strong>, {{ $advisory->position }}
                                    — {{ $advisory->area_of_responsibility }}
                                    · {{ $advisory->date_published->format('M d, Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emerald = '#1B5E20';
            const gold = '#FFC107';

            @if ($mostOrdered->isNotEmpty())
            new Chart(document.getElementById('mostOrderedChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($mostOrdered->pluck('commodity_type')) !!},
                    datasets: [{
                        label: 'Units Sold',
                        data: {!! json_encode($mostOrdered->pluck('total_quantity')) !!},
                        backgroundColor: emerald,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
            @endif

            @if ($monthlyTrend->isNotEmpty())
            new Chart(document.getElementById('monthlyTrendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyTrend->map(fn($t) => \Carbon\Carbon::createFromFormat('Y-m', $t->month)->format('M Y'))) !!},
                    datasets: [{
                        label: 'Units Ordered',
                        data: {!! json_encode($monthlyTrend->pluck('total_quantity')) !!},
                        borderColor: gold,
                        backgroundColor: gold,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
            @endif
        });
    </script>
</x-app-layout>