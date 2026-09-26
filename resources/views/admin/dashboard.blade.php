<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome + Quick actions -->
            <div class="bg-white shadow-sm rounded-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-lg font-semibold text-gray-900">Welcome, {{ auth()->user()->name }}!</p>
                    <p class="text-sm text-gray-500">Here's what's happening on TERESA today.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.create-farmer') }}"
                       class="inline-flex items-center gap-2 bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                        <span class="text-base leading-none">+</span> Register Farmer
                    </a>
                    <a href="{{ route('admin.advisories.create') }}"
                       class="inline-flex items-center gap-2 border border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold px-4 py-2 rounded-md text-sm transition">
                        <span class="text-base leading-none">+</span> Publish Advisory
                    </a>
                </div>
            </div>

            <!-- 1. Quick stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $cards = [
                        ['label' => 'Registered Farmers', 'value' => $stats['farmers']],
                        ['label' => 'Registered Buyers',  'value' => $stats['buyers']],
                        ['label' => 'Active Listings',    'value' => $stats['activeListings']],
                        ['label' => 'Orders This Month',  'value' => $stats['ordersThisMonth']],
                    ];
                @endphp
                @foreach ($cards as $card)
                    <div class="bg-white shadow-sm rounded-lg p-5 border-t-4 border-primary-600">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold text-primary-700">{{ number_format($card['value']) }}</p>
                    </div>
                @endforeach
            </div>

            <!-- 2 + 4. Two-column section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Pending reports -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">
                            Pending Reports
                            @if ($pendingReportsCount > 0)
                                <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-accent-500 rounded-full">{{ $pendingReportsCount }}</span>
                            @endif
                        </h3>
                        <a href="{{ route('admin.reports.index') }}" class="text-sm text-primary-600 hover:underline">View all</a>
                    </div>

                    @forelse ($pendingReports as $report)
                        <div class="flex items-start justify-between gap-3 py-3 border-t border-gray-100 first:border-t-0">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $report->reason }}</p>
                                <p class="text-xs text-gray-500">
                                    Against {{ $report->reportedUser?->name ?? 'Unknown user' }}
                                    · by {{ $report->reporter?->name ?? 'Unknown' }}
                                    · {{ $report->created_at?->diffForHumans() }}
                                </p>
                            </div>
                            <a href="{{ route('admin.reports.index') }}"
                               class="flex-shrink-0 text-xs font-semibold border border-primary-600 text-primary-600 hover:bg-primary-50 px-3 py-1 rounded-md">
                                Review
                            </a>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No pending reports. All clear! ✅</p>
                    @endforelse

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <p class="text-sm text-gray-600">Deactivated accounts</p>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-900 hover:text-primary-600">
                            {{ $deactivatedCount }}
                        </a>
                    </div>
                </div>

                <!-- Latest advisories -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Latest Advisories</h3>
                        <a href="{{ route('admin.advisories.create') }}" class="text-sm text-primary-600 hover:underline">+ New</a>
                    </div>

                    @forelse ($latestAdvisories as $advisory)
                        <div class="py-3 border-t border-gray-100 first:border-t-0">
                            <p class="text-sm font-medium text-gray-900">{{ $advisory->title }}</p>
                            <p class="text-xs text-gray-500">
                                @if ($advisory->category){{ $advisory->category }} · @endif
                                {{ $advisory->date_published?->format('M d, Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No advisories published yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Newest farmers -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Newest Farmers</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-primary-600 hover:underline">View all users</a>
                </div>

                @forelse ($newestFarmers as $farmerUser)
                    <div class="flex items-center justify-between gap-3 py-3 border-t border-gray-100 first:border-t-0">
                        <div class="min-w-0">
                            <a href="{{ route('admin.users.show', $farmerUser) }}" class="text-sm font-medium text-gray-900 hover:text-primary-600">
                                {{ $farmerUser->farmer?->full_name ?? $farmerUser->name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $farmerUser->farmer?->barangay ?? '—' }}</p>
                        </div>
                        <p class="flex-shrink-0 text-xs text-gray-500">Registered {{ $farmerUser->created_at?->format('M d, Y') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No farmers registered yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>