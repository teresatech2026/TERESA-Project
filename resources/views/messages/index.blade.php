<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($conversations->isEmpty())
                    <p class="text-gray-500">No conversations yet.</p>
                @else
                    <div class="divide-y">
                        @foreach ($conversations as $conversation)
                            <a href="{{ route('messages.show', $conversation->partner) }}"
                               class="flex justify-between items-center py-4 hover:bg-gray-50 px-2 -mx-2 rounded">
                                <div>
                                    <p class="font-semibold">{{ $conversation->partner->name }}</p>
                                    <p class="text-sm text-gray-500 truncate max-w-md">
                                        {{ $conversation->last_message?->message_text ?? 'No messages yet' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">
                                        {{ $conversation->last_message?->created_at->diffForHumans() }}
                                    </p>
                                    @if ($conversation->unread_count > 0)
                                        <span class="inline-block mt-1 bg-accent-500 text-gray-900 text-xs font-semibold px-2 py-0.5 rounded-full">
                                            {{ $conversation->unread_count }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>