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
                            required
                            disabled
                            class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 appearance-none cursor-pointer">
                            <option value="">Select a country</option>

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
                            required
                            disabled
                            class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 appearance-none cursor-pointer">
                            <option value="">Select a city</option>

                        </select>
                        <!-- Custom Dropdown Arrow -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>


            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countrySelect = document.getElementById('country');
            const citySelect = document.getElementById('city');

            // Helper to get Laravel CSRF Token from meta tag or cookie
            const getCsrfToken = () => {
                return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            };

            // 1. AJAX Function to get countries on page load (via POST)
            async function loadCountries() {
                try {
                    const response = await fetch('/countries', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        }
                    });

                    if (!response.ok) throw new Error('Failed to fetch countries');

                    const countries = await response.json();

                    countrySelect.innerHTML = '<option value="" disabled selected>Select a country</option>';
                    countrySelect.disabled = false;

                    countries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.id;
                        option.textContent = country.name;
                        countrySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching countries:', error);
                    countrySelect.innerHTML = '<option value="" disabled selected>Error loading countries</option>';
                }
            }

            // 2. AJAX Function to get cities when a country is picked (via POST)
            countrySelect.addEventListener('change', async function() {
                const countryCode = this.value;

                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="" disabled selected>Loading cities...</option>';

                if (!countryCode) return;

                try {
                    const response = await fetch('/cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        body: JSON.stringify({
                            country: countryCode
                        }) // Passed cleanly inside the body payload
                    });

                    if (!response.ok) throw new Error('Failed to fetch cities');

                    const cities = await response.json();

                   
                    citySelect.innerHTML = '<option value="" disabled selected>Select a city</option>';
                    citySelect.disabled = false;

                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching cities:', error);
                    citySelect.innerHTML = '<option value="" disabled selected>Error loading cities</option>';
                }
            });

            // Run the country fetch immediately on page load
            loadCountries();
        });
    </script>

</x-layouts::app>