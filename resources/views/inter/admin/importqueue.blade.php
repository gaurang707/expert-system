<x-layouts::app :title="__('Import Users')">

    <!-- CSV User Import Page -->
    <div class="mx-auto max-w-6xl space-y-6 p-4 sm:p-6">
        @if (session('import_errors'))

        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4">

            <h3 class="mb-2 font-semibold text-red-700">
                CSV Import Failed
            </h3>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">

                @foreach (session('import_errors') as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif

        @error('csv_file')
        <p class="mb-3 text-sm text-red-600">
            {{ $message }}
        </p>
        @enderror

        @if (session('success'))

        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>

        @endif
        <!-- Page Header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Import Users
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Upload a CSV file to import multiple users into your system.
                </p>
            </div>

            <button type="button"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <span>↓</span>
                Download Sample CSV
            </button>
        </div>

        <!-- Upload CSV Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900">
                    Upload CSV File
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Select a CSV file containing user information.
                </p>
            </div>

            <form method="POST" action="{{ route('importcsv.storequeue') }}" enctype="multipart/form-data">
                @csrf

                <!-- Replace action with Laravel route and add @csrf -->

                <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center transition hover:border-blue-400 hover:bg-blue-50/30">

                    <!-- Upload Icon -->
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-7 w-7 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 16V4m0 0L7 9m5-5 5 5M4 16v3a2 2 0 002 2h12a2 2 0 002-2v-3" />
                        </svg>
                    </div>

                    <h3 class="text-base font-semibold text-gray-900">
                        Choose your CSV file
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Supported format: .csv
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Maximum file size: 2 MB | Maximum 1,000 records
                    </p>

                    <div class="mt-5">
                        <input
                            type="file"
                            name="csv_file"
                            id="csv_file"
                            class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-700
                        file:mr-4 file:cursor-pointer file:border-0 file:bg-blue-600
                        file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white
                        hover:file:bg-blue-700 sm:mx-auto sm:max-w-md">

                        @error('csv_file')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Upload Instructions -->
                <div class="mt-5 rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <h4 class="text-sm font-semibold text-blue-900">
                        Important Instructions
                    </h4>

                    <ul class="mt-2 list-inside list-disc space-y-1.5 text-sm text-blue-800">
                        <li>Only CSV files are allowed.</li>
                        <li>The first row must contain column headers.</li>
                        <li>Required columns: name, email, status, role.</li>
                        <li>Email addresses must be unique.</li>
                        <li>Status must be active or inactive.</li>
                        <li>Role must already exist in the database.</li>
                    </ul>
                </div>

                <!-- Form Buttons -->
                <div class="mt-6 flex flex-wrap justify-end gap-3">

                    <button type="reset"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Reset
                    </button>

                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">

                        <svg class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 16V4m0 0L7 9m5-5 5 5M4 16v3a2 2 0 002 2h12a2 2 0 002-2v-3" />
                        </svg>

                        Import Users
                    </button>

                </div>

            </form>

        </div>

        <!-- Sample CSV Data -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 p-5">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Sample CSV Preview
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Your CSV file should follow this format.
                    </p>
                </div>

                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                    Example Data
                </span>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                #
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Name
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Email
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Role
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">1</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                Rahul Shah
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                rahul@example.com
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">Admin</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">2</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                Priya Patel
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                priya@example.com
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">Manager</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">3</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                Amit Mehta
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                amit@example.com
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                    Inactive
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">Staff</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">4</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                Neha Desai
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                neha@example.com
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">Customer</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">5</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                Vikram Patel
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                vikram@example.com
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">Editor</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Sample Import Results -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Import Results
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Example results after processing a CSV file.
                    </p>
                </div>

                <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    Completed
                </span>

            </div>

            <!-- Result Statistics -->
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                <!-- Total -->
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">Total Records</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">100</h3>
                </div>

                <!-- Imported -->
                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-700">
                        Imported
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-green-700">95</h3>
                </div>

                <!-- Skipped -->
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm font-medium text-amber-700">
                        Skipped
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-amber-700">3</h3>
                </div>

                <!-- Failed -->
                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="text-sm font-medium text-red-700">
                        Failed
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-red-700">2</h3>
                </div>

            </div>

            <!-- Success Message -->
            <div class="mt-5 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4">

                <span class="text-xl text-green-600">✓</span>

                <div>
                    <h4 class="text-sm font-semibold text-green-800">
                        Import completed successfully!
                    </h4>

                    <p class="mt-1 text-sm text-green-700">
                        95 users were imported successfully.
                        3 records were skipped and 2 records failed validation.
                    </p>
                </div>

            </div>

        </div>

        <!-- Validation Errors -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 p-5">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Validation Errors
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        The following rows could not be imported.
                    </p>
                </div>

                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                    2 Errors
                </span>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Row
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Email
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Error
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        <tr>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                12
                            </td>

                            <td class="px-5 py-4 text-sm text-gray-600">
                                invalid-email
                            </td>

                            <td class="px-5 py-4 text-sm text-red-600">
                                Invalid email address.
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    Failed
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                25
                            </td>

                            <td class="px-5 py-4 text-sm text-gray-600">
                                user25@example.com
                            </td>

                            <td class="px-5 py-4 text-sm text-red-600">
                                Selected role does not exist.
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    Failed
                                </span>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="flex flex-wrap justify-end gap-3 border-t border-gray-200 p-4">

                <button type="button"
                    class="rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                    Download Failed Records
                </button>

                <button type="button"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    Back to Users
                </button>

            </div>

        </div>

    </div>

</x-layouts::app>