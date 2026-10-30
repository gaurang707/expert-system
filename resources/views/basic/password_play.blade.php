<x-layouts::app :title="__('Password Show|Hide')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="w-full max-w-sm mx-auto space-y-1.5">
            <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
            <div class="relative rounded-lg shadow-sm">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-slate-50/50 pl-4 pr-10 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                <!-- Static Eye Button -->
                <button
                    type="button"
                    onclick="togglePasswordVisibility('password', this)"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer"
                    title="Toggle password visibility">
                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 eye-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 eye-off-icon hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, button) {
            const inputField = document.getElementById(fieldId);
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');

            if (inputField.type === 'password') {
                // Show password
                inputField.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                // Hide password
                inputField.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        // document.addEventListener('DOMContentLoaded', (event) => {
        //     const password = document.getElementById('password');
        //     const togglePassword = document.getElementById('togglePassword');
        //     const iconSlash = document.getElementsByClassName('icon-slash');

        //     const flag = false;

        //     function toggleFlag(val) {
        //         if (!val) {

        //         }
        //     }

        //     togglePassword.addEventListener("click", () => {
        //         console.log("click add event");
        //         if (password.type == "password") {
        //             password.type = "text";


        //             toggleFlag(flag);

        //         } else {
        //             password.type = "password";

        //             toggleFlag(flag);


        //         }
        //     });

        // });
    </script>

</x-layouts::app>