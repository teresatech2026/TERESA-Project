<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($notifications->isEmpty())
                    <p class="text-gray-500">No notifications yet.</p>
                @else
                    <div class="divide-y">
                        @foreach ($notifications as $notification)
                            <a href="{{ $notification->url ?? route('dashboard') }}"
                               class="block py-4 hover:bg-gray-50 px-2 -mx-2 rounded">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-sm">{{ $notification->title }}</p>
                                        @if ($notification->content)
                                            <p class="text-sm text-gray-500 mt-1">{{ $notification->content }}</p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>