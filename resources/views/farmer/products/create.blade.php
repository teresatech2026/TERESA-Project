<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('farmer.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <h3 class="font-semibold text-lg mb-2">Product Information</h3>

                    <div class="mb-4">
                        <x-input-label for="product_name" value="Product Name" />
                        <x-text-input id="product_name" name="product_name" class="block mt-1 w-full" :value="old('product_name')" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="commodity_type" value="Commodity Type" />
                            <x-text-input id="commodity_type" name="commodity_type" class="block mt-1 w-full" :value="old('commodity_type')" placeholder="e.g. Vegetable, Rice, Fruit" required />
                        </div>
                        <div>
                            <x-input-label for="category" value="Category" />
                            <x-text-input id="category" name="category" class="block mt-1 w-full" :value="old('category')" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="variety" value="Variety (optional)" />
                        <x-text-input id="variety" name="variety" class="block mt-1 w-full" :value="old('variety')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <x-input-label for="selling_price" value="Selling Price (₱)" />
                            <x-text-input id="selling_price" name="selling_price" type="number" step="0.01" class="block mt-1 w-full" :value="old('selling_price')" required />
                        </div>
                        <div>
                            <x-input-label for="unit_of_measurement" value="Unit" />
                            <x-text-input id="unit_of_measurement" name="unit_of_measurement" class="block mt-1 w-full" :value="old('unit_of_measurement')" placeholder="e.g. kg, sack, piece" required />
                        </div>
                        <div>
                            <x-input-label for="available_quantity" value="Available Quantity" />
                            <x-text-input id="available_quantity" name="available_quantity" type="number" step="0.01" class="block mt-1 w-full" :value="old('available_quantity')" required />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="minimum_order_quantity" value="Minimum Order Quantity (optional)" />
                        <x-text-input id="minimum_order_quantity" name="minimum_order_quantity" type="number" step="0.01" class="block mt-1 w-full" :value="old('minimum_order_quantity')" />
                    </div>

                    <h3 class="font-semibold text-lg mb-2 border-t pt-4">Harvest Information</h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="harvest_date" value="Harvest Date" />
                            <x-text-input id="harvest_date" name="harvest_date" type="date" class="block mt-1 w-full" :value="old('harvest_date')" required />
                        </div>
                        <div>
                            <x-input-label for="estimated_shelf_life_days" value="Estimated Shelf Life (days, optional)" />
                            <x-text-input id="estimated_shelf_life_days" name="estimated_shelf_life_days" type="number" class="block mt-1 w-full" :value="old('estimated_shelf_life_days')" />
                        </div>
                    </div>

                    <h3 class="font-semibold text-lg mb-2 border-t pt-4">Product Quality</h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="product_grade" value="Product Grade" />
                            <x-text-input id="product_grade" name="product_grade" class="block mt-1 w-full" :value="old('product_grade')" placeholder="e.g. Grade A" />
                        </div>
                        <div>
                            <x-input-label for="product_condition" value="Product Condition" />
                            <x-text-input id="product_condition" name="product_condition" class="block mt-1 w-full" :value="old('product_condition')" placeholder="e.g. Fresh, Dried" />
                        </div>
                        <div>
                            <x-input-label for="production_method" value="Production Method" />
                            <x-text-input id="production_method" name="production_method" class="block mt-1 w-full" :value="old('production_method')" placeholder="e.g. Organic, Conventional" />
                        </div>
                        <div>
                            <x-input-label for="size_weight_classification" value="Size/Weight Classification (optional)" />
                            <x-text-input id="size_weight_classification" name="size_weight_classification" class="block mt-1 w-full" :value="old('size_weight_classification')" />
                        </div>
                    </div>

                    <h3 class="font-semibold text-lg mb-2 border-t pt-4">Product Images</h3>

                    <div class="mb-6">
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md" />
                        <p class="text-xs text-gray-500 mt-1">You can select multiple images. The first one will be used as the main photo.</p>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Add Product') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>