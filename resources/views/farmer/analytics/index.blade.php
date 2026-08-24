<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Sales Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Summary Stats -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Overview</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">₱{{ number_format($stats['total_revenue'], 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Revenue (Completed)</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['total_orders'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Orders</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['completed_orders'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Completed Orders</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['active_products'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Active Listings</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">⭐ {{ number_format($stats['overall_rating'], 1) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Overall Rating</p>
                    </div>
                    <div class="border border-primary-600 rounded-lg p-4">
                        <p class="text-2xl font-bold text-primary-600">{{ $stats['total_reviews'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Reviews</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Revenue Trend -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Revenue Trend (Last 6 Months)</h3>
                    @if ($monthlyRevenue->isEmpty())
                        <p class="text-gray-400 text-sm">No sales data yet.</p>
                    @else
                        <canvas id="revenueChart" height="200"></canvas>
                    @endif
                </div>

                <!-- Order Status Breakdown -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Status Breakdown</h3>
                    @if ($statusBreakdown->isEmpty())
                        <p class="text-gray-400 text-sm">No orders yet.</p>
                    @else
                        <canvas id="statusChart" height="200"></canvas>
                    @endif
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Your Best-Selling Products</h3>
                @if ($topProducts->isEmpty())
                    <p class="text-gray-400 text-sm">No sales data yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2">Product</th>
                                <th class="py-2">Quantity Sold</th>
                                <th class="py-2">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($topProducts as $product)
                                <tr>
                                    <td class="py-2">{{ $product->product_name }}</td>
                                    <td class="py-2">{{ number_format($product->total_qty, 2) }}</td>
                                    <td class="py-2 font-medium">₱{{ number_format($product->total_revenue, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emerald = '#1B5E20';
            const gold = '#FFC107';

            @if ($monthlyRevenue->isNotEmpty())
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyRevenue->map(fn($t) => \Carbon\Carbon::createFromFormat('Y-m', $t->month)->format('M Y'))) !!},
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: {!! json_encode($monthlyRevenue->pluck('total_revenue')) !!},
                        borderColor: emerald,
                        backgroundColor: emerald,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });
            @endif

            @if ($statusBreakdown->isNotEmpty())
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusBreakdown->map(fn($s) => ucwords(str_replace('_', ' ', $s->status)))) !!},
                    datasets: [{
                        data: {!! json_encode($statusBreakdown->pluck('count')) !!},
                        backgroundColor: [emerald, gold, '#5c9c63', '#e6ac00', '#9fc4a3', '#dc2626'],
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
            @endif
        });
    </script>
</x-app-layout>