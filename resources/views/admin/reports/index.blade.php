<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Reports') }}
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

                <!-- Tabs -->
                <div class="flex gap-2 mb-6 border-b">
                    @foreach (['pending' => 'Pending', 'reviewed' => 'Reviewed', 'dismissed' => 'Dismissed', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('admin.reports.index', ['status' => $value]) }}"
                           class="px-4 py-2 text-sm font-medium border-b-2
                               {{ $status === $value ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                @if ($reports->isEmpty())
                    <p class="text-gray-500">No reports found.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($reports as $report)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm">
                                            <strong>{{ $report->reporter->name }}</strong> ({{ $report->reporter->role }})
                                            reported
                                            <strong>{{ $report->reportedUser->name }}</strong> ({{ $report->reportedUser->role }})
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $report->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                    <span class="inline-block text-xs px-2 py-1 rounded-full
                                        @switch($report->status)
                                            @case('pending') bg-yellow-100 text-yellow-700 @break
                                            @case('reviewed') bg-green-100 text-green-700 @break
                                            @case('dismissed') bg-gray-100 text-gray-600 @break
                                        @endswitch">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </div>

                                <p class="text-sm font-medium mt-2">Reason: {{ $report->reason }}</p>
                                @if ($report->details)
                                    <p class="text-sm text-gray-600 mt-1">{{ $report->details }}</p>
                                @endif
                                @if ($report->relatedOrder)
                                    <p class="text-xs text-gray-400 mt-1">Related to Order #{{ $report->relatedOrder->id }}</p>
                                @endif

                                @if ($report->status === 'pending')
                                    <div class="flex gap-2 mt-3">
                                        <form method="POST" action="{{ route('admin.reports.updateStatus', $report) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="reviewed">
                                            <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-3 py-1.5 rounded-md text-xs transition">
                                                Mark as Reviewed
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reports.updateStatus', $report) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="dismissed">
                                            <button type="submit" class="border border-gray-400 text-gray-600 hover:bg-gray-50 font-semibold px-3 py-1.5 rounded-md text-xs">
                                                Dismiss
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