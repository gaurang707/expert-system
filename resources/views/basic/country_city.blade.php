<x-layouts::app :title="__('Counter Reset')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <form method="get" action="{{ route('country_city')}}">
            <div class="w-full max-w-md mx-auto space-y-5 bg-white p-6 border border-slate-100 rounded-2xl shadow-sm">
                <!-- Country Dropdown Field -->
                <div class="space-y-1.5">
                    <label for="country" class="text-sm font-semibold text-slate-700">Country</label>
                    <div class="relative">
                        <select
                            id="country"
                            name="country"

                            class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 appearance-none cursor-pointer">
                            <option value="">Select a country</option>
                            @foreach ($countries as $country)
                            @if($searchTerm == $country->id)
                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                            @else
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endif

                            @endforeach

                        </select>
                        <!-- Custom Dropdown Arrow -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>



                <!-- City Dropdown Field -->
                <div class="space-y-1.5">
                    <label for="city" class="text-sm font-semibold text-slate-700">City</label>
                    <div class="relative">
                        <select
                            id="city"
                            name="city"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 appearance-none disabled:opacity-50 disabled:bg-slate-100 disabled:cursor-not-allowed cursor-pointer">
                            <option value="" disabled selected>Select a city</option>
                            @foreach ($cities as $city)
                            @if($city->id == $city_searchTerm)
                            <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                            @else
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endif

                            @endforeach
                        </select>
                        <!-- Custom Dropdown Arrow -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:bg-blue-800 transition-colors cursor-pointer">
                    Select country and get the cities
                </button>
            </div>

        </form>

    </div>

    </x-layouts>