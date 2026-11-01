<x-layouts::app :title="__('Password Show|Hide')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="w-full max-w-2xl bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8 space-y-6">
            <!-- Header -->
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Product Catalog</h1>

            <!-- Search Form -->
            <form action="{{ route('product-catalog') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2.5">
                <input
                    id="product_catalog_search"
                    type="text"
                    name="search"
                    value="{{ $searchTerm ?? '' }}"
                    placeholder="Search products..."
                    class="w-full flex-1 px-4 py-2 border border-gray-300 rounded-full text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="flex-1 sm:flex-initial px-6 py-2 bg-black hover:bg-neutral-800 text-white text-sm font-medium rounded-full transition duration-150 cursor-pointer">
                        Search
                    </button>
                    <button
                        type="submit"
                        name="resetbutton"
                        value="resetbutton"
                        class="flex-1 sm:flex-initial px-6 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-full transition duration-150 cursor-pointer">
                        Reset
                    </button>
                </div>
            </form>

            <!-- Subtitle Note -->
            <p class="text-sm text-gray-500">
                Illustrative search preview using sample products.
            </p>

            <!-- Results List -->
            <div class="divide-y divide-gray-100">
                <!-- Item 1 -->

                @forelse ($products as $product)
                <div class="py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::words($product->description, 8, '...') }}</p>
                    </div>
                    <span class="text-base font-semibold text-gray-900">₹{{ $product->price }}</span>
                </div>
                @empty
                <div class="py-4 flex items-center justify-between">
                    <div>
                        <p>Not found any product</p>
                    </div>

                </div>
                @endforelse



                <!-- Item 2 -->
                <!-- <div class="py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">HP Pavilion Laptop</h2>
                        <p class="text-sm text-gray-500">Laptop for work and everyday use</p>
                    </div>
                    <span class="text-base font-semibold text-gray-900">₹59,999</span>
                </div> -->
            </div>

            <!-- Footer Note -->
            <div class="pt-2">
                <span class="text-xs text-gray-500 font-mono">
                    Example URL: /product-catalog?search={{$searchTerm}}
                </span>
            </div>
        </div>

    </div>

</x-layouts::app>