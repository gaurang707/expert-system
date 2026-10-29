<x-layouts::app :title="__('Counter Reset')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-center min-h-[200px] bg-gray-50">
            <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1 shadow-sm max-w-[140px]">
                <!-- Decrement Button -->
                <button
                    id="decrement-btn"
                    type="button"
                    class="inline-flex items-center justify-center h-8 w-8 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    aria-label="Decrease quantity">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://w3.org" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                    </svg>
                </button>

                <!-- Quantity Input -->
                <input
                    id="counter-input"
                    type="number"
                    value="1"
                    min="1"
                    max="99"
                    class="w-12 text-center bg-transparent border-0 text-sm font-semibold text-gray-800 focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                    required />

                <!-- Increment Button -->
                <button
                    id="increment-btn"
                    type="button"
                    class="inline-flex items-center justify-center h-8 w-8 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    aria-label="Increase quantity">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://w3.org" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const i_btn = document.getElementById('increment-btn');
            const d_btn = document.getElementById('decrement-btn');
            const input = document.getElementById('counter-input');

            //Parse  values from input attributes safely

            const getMinMax = () => ({
                min: parseInt(input.getAttribute('min')) || 1,
                max: parseInt(input.getAttribute('max')) || 99
            });

            d_btn.addEventListener("click", () => {
                console.log("click add event");
                const {
                    min
                } = getMinMax();

                let current = parseInt(input.value) || 0;
                if (current > min) {
                    input.value = current - 1;
                }

            });


            i_btn.addEventListener("click", () => {
                console.log("click substract event");
                const {
                    max
                } = getMinMax();
                let current = parseInt(input.value) || 0;
                if (current < max) {
                    input.value = current + 1;
                }

            });

            input.addEventListener('change', () => {
                const {
                    min,
                    max
                } = getMinMax();
                let current = parseInt(input.value);
                if (isNaN(current) || current < min) input.value = min;
                if (current > max) input.value = max;
            });
        });
    </script>

</x-layouts::app>