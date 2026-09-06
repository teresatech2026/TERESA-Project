@props([
    'action',
    'method' => 'POST',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmText' => 'Yes, Continue',
    'cancelText' => 'Cancel',
    'confirmClass' => 'bg-red-600 hover:bg-red-700 text-white',
])

<div x-data="{ open: false }" class="inline-block" @keydown.escape.window="open = false">
    <span @click="open = true" class="cursor-pointer">
        {{ $trigger }}
    </span>

    <div x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div class="fixed inset-0 bg-black/40" @click="open = false"></div>

        <div x-show="open" x-transition
             class="relative bg-white rounded-lg shadow-xl max-w-sm w-full p-6 text-center">
            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-600 mb-6">{{ $message }}</p>

            <div class="flex justify-center gap-3">
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 rounded-md">
                    {{ $cancelText }}
                </button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-md {{ $confirmClass }}">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>