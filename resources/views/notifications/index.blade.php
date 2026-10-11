<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    @php
        $statusClasses = function (string $label) {
            return match (strtolower($label)) {
                'completed' => 'bg-green-100 text-green-700 border-green-200',
                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                default     => 'bg-primary-50 text-primary-700 border-primary-200',
            };
        };
    @endphp

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($entries->isEmpty())
                    <p class="text-gray-500">No notifications yet.</p>
                @else
                    <div class="divide-y">
                        @foreach ($entries as $entry)

                            @if ($entry->kind === 'order')
                                {{-- One card per order: current status + expandable history --}}
                                <div class="py-4" x-data="{ open: false }">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-sm">
                                                {{ $entry->order_id ? 'Order #' . $entry->order_id : $entry->latest->title }}
                                                @if ($entry->has_unread)
                                                    <span class="ml-1 text-xs font-medium px-2 py-0.5 rounded-full bg-accent-500 text-white">New</span>
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Current status:
                                                <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full border {{ $statusClasses($entry->latest->status_label) }}">
                                                    {{ $entry->latest->status_label }}
                                                </span>
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                            {{ $entry->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    <div class="mt-2 flex items-center gap-4 text-xs">
                                        <a href="{{ $entry->latest->url ?? route('dashboard') }}"
                                           class="text-primary-600 hover:underline font-medium">View order</a>

                                        @if ($entry->updates->count() > 1)
                                            <button type="button" @click="open = !open"
                                                    class="text-gray-500 hover:text-gray-700">
                                                <span x-text="open ? 'Hide history' : 'Show history ({{ $entry->updates->count() }} updates)'"></span>
                                            </button>
                                        @endif
                                    </div>

                                    @if ($entry->updates->count() > 1)
                                        <ol x-show="open" x-cloak
                                            class="mt-3 ml-1 border-l-2 border-gray-200 pl-4 space-y-2">
                                            @foreach ($entry->updates as $update)
                                                <li class="flex justify-between items-center text-sm">
                                                    <span class="text-gray-700">{{ $update->status_label }}</span>
                                                    <span class="text-xs text-gray-400 ml-4 whitespace-nowrap">
                                                        {{ $update->created_at->format('M d, g:i A') }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>

                            @else
                                {{-- Any other notification stays as a single row --}}
                                @php $notification = $entry->notification; @endphp
                                <a href="{{ $notification->url ?? route('dashboard') }}"
                                   class="block py-4 hover:bg-gray-50 px-2 -mx-2 rounded">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-sm">
                                                {{ $notification->title }}
                                                @if ($entry->has_unread)
                                                    <span class="ml-1 text-xs font-medium px-2 py-0.5 rounded-full bg-accent-500 text-white">New</span>
                                                @endif
                                            </p>
                                            @if ($notification->content)
                                                <p class="text-sm text-gray-500 mt-1">{{ $notification->content }}</p>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </a>
                            @endif

                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>