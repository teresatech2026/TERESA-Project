<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publish Agricultural Advisory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.advisories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" class="block mt-1 w-full" :value="old('title')" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="category" value="Category (optional)" />
                        <x-text-input id="category" name="category" class="block mt-1 w-full" :value="old('category')" placeholder="e.g. Pest Control, Weather Advisory, Planting Tips" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="content" value="Content" />
                        <textarea id="content" name="content" rows="6" required
                            class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" value="Image (optional)" />
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block mt-1 w-full text-sm text-gray-600 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                    <x-input-label for="date_published" value="Date to Publish" />
                    <x-text-input id="date_published" name="date_published" type="date" class="block mt-1 w-full"
                        :value="old('date_published', now()->format('Y-m-d'))" required />
                </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="prepared_by" value="Prepared By" />
                            <x-text-input id="prepared_by" name="prepared_by" class="block mt-1 w-full" :value="old('prepared_by')" required />
                        </div>
                        <div>
                            <x-input-label for="position" value="Position" />
                            <x-text-input id="position" name="position" class="block mt-1 w-full" :value="old('position')" placeholder="e.g. Agricultural Technician" required />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="area_of_responsibility" value="Area of Responsibility" />
                        <x-text-input id="area_of_responsibility" name="area_of_responsibility" class="block mt-1 w-full" :value="old('area_of_responsibility')" placeholder="e.g. Vegetable Crops" required />
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('market-analytics.index') }}"
                           class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-semibold">
                            Cancel
                        </a>
                        <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                            Publish Advisory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>