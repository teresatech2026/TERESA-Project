<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $partner->name }}
        </h2>
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.create', $partner) }}" class="text-sm text-red-500 hover:underline">
                Report User
            </a>
            <a href="{{ route('messages.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to Messages
            </a>
        </div>
    </div>
</x-slot>

    <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-[32rem]">

                <!-- Message thread -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    @forelse ($messages as $message)
                        @php $isMine = $message->sender_id === auth()->id(); @endphp
                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs px-4 py-2 rounded-lg text-sm
                                {{ $isMine ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                                <p>{{ $message->message_text }}</p>
                                <p class="text-xs mt-1 {{ $isMine ? 'text-primary-100' : 'text-gray-400' }}">
                                    {{ $message->created_at->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center mt-10">Say hello to start the conversation.</p>
                    @endforelse
                </div>

                <!-- Send message form -->
                <form method="POST" action="{{ route('messages.store', $partner) }}" class="border-t p-3 flex gap-2">
                    @csrf
                    <input type="text" name="message_text" required autocomplete="off" placeholder="Type a message..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                    Send
                    </button>
                    </button>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>