<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Click your photo to upload a new one, so farmers and buyers can recognize you.') }}
        </p>
    </header>

    <div class="mt-6 flex items-center gap-6" x-data="{ uploading: false }">

        <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data"
              x-ref="photoForm" @submit="uploading = true">
            @csrf

            <label for="photo-input" class="relative block w-20 h-20 rounded-full cursor-pointer group">
                @if ($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                         class="w-20 h-20 rounded-full object-cover border-4 border-accent-500 group-hover:opacity-80 transition">
                @else
                    <div class="w-20 h-20 rounded-full bg-primary-50 text-primary-700 border-4 border-accent-500 flex items-center justify-center text-2xl font-semibold group-hover:opacity-80 transition">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <!-- Camera badge indicating the photo is clickable -->
                <span class="absolute bottom-0 right-0 bg-accent-500 text-white rounded-full p-1.5 border-2 border-white shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>

                <!-- Spinner overlay while uploading -->
                <span x-show="uploading" x-cloak
                      class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center">
                    <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </label>

            <input id="photo-input" type="file" name="photo" accept="image/*" class="hidden"
                   @change="$refs.photoForm.submit()">
        </form>

        <div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

            @if (session('status') === 'photo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Photo updated.') }}
                </p>
            @endif

            @if (session('status') === 'photo-removed')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Photo removed.') }}
                </p>
            @endif

            @if ($user->profile_photo_url)
                <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-2">
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