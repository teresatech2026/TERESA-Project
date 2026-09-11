<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Upload a photo so farmers and buyers can recognize you.') }}
        </p>
    </header>

    <div class="mt-6 flex items-center gap-6">
        @if ($user->profile_photo_url)
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                 class="w-20 h-20 rounded-full object-cover border border-gray-200">
        @else
            <div class="w-20 h-20 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-2xl font-semibold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <div class="flex-1">
            <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <input type="file" name="photo" accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md">
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />

                <div class="flex items-center gap-3">
                    <x-primary-button>{{ __('Upload Photo') }}</x-primary-button>

                    @if (session('status') === 'photo-updated')
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Photo updated.') }}</p>
                    @endif
                </div>
            </form>

            @if ($user->profile_photo_url)
                <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-3">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-xs text-red-500 hover:underline">
                        {{ __('Remove photo') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>