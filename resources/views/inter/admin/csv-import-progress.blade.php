<div
    id="csv-import-progress"
    data-status-url="{{ route('admin.csv-imports.status', $import->id) }}"
    class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                CSV Import Progress
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ $import->file_name }}
            </p>
        </div>

        <span
            id="importStatus"
            class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
            {{ ucfirst($import->status) }}
        </span>
    </div>

    <!-- Progress information -->
    <div class="flex justify-between items-center mb-3">
        <span class="text-sm font-medium text-gray-700">
            Importing Users
        </span>

        <span
            id="progressPercent"
            class="text-lg font-semibold text-gray-900">
            0%
        </span>
    </div>

    <!-- Progress bar -->
    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">

        <div
            id="progressBar"
            class="bg-green-500 h-4 rounded-full transition-all duration-500"
            role="progressbar"
            aria-label="CSV import progress"
            aria-valuemin="0"
            aria-valuemax="100"
            aria-valuenow="0"
            style="width: 0%"></div>

    </div>

    <!-- Processed count -->
    <p class="text-sm text-gray-500 mt-3">
        <span id="processedCount">0</span>
        of
        <span id="totalCount">0</span>
        records processed
    </p>

    <!-- Statistics -->
    <div class="grid grid-cols-3 gap-4 mt-6">

        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-sm text-green-700">Successful</p>

            <p
                id="successCount"
                class="text-2xl font-bold text-green-800 mt-1">
                0
            </p>
        </div>

        <div class="bg-red-50 rounded-lg p-4">
            <p class="text-sm text-red-700">Failed</p>

            <p
                id="failedCount"
                class="text-2xl font-bold text-red-800 mt-1">
                0
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">Remaining</p>

            <p
                id="remainingCount"
                class="text-2xl font-bold text-gray-800 mt-1">
                0
            </p>
        </div>

    </div>

    <p id="progressMessage" class="text-sm text-gray-500 mt-5">
        Waiting for import to start...
    </p>

</div>

<script>
    $(document).ready(function() {

        const $container = $('#csv-import-progress');

        const statusUrl = $container.data('status-url');

        const pollingInterval = 3000; // 3 seconds

        function checkImportProgress() {

            $.ajax({
                url: statusUrl,
                type: 'GET',
                dataType: 'json',
                cache: false,

                success: function(response) {

                    const percentage = Math.max(
                        0,
                        Math.min(100, Number(response.percentage) || 0)
                    );

                    // Update progress bar
                    $('#progressBar')
                        .css('width', percentage + '%')
                        .attr('aria-valuenow', percentage);

                    $('#progressPercent').text(
                        percentage.toFixed(0) + '%'
                    );

                    // Update statistics
                    $('#processedCount').text(response.processed_rows);
                    $('#totalCount').text(response.total_rows);

                    $('#successCount').text(response.success_rows);
                    $('#failedCount').text(response.failed_rows);
                    $('#remainingCount').text(response.remaining_rows);

                    // Update status
                    $('#importStatus').text(response.status);

                    if (response.status === 'completed') {

                        $('#progressMessage')
                            .text('CSV import completed successfully.')
                            .removeClass('text-red-600')
                            .addClass('text-green-600');

                        // Stop polling.
                        return;
                    }

                    if (response.status === 'failed') {

                        $('#progressMessage')
                            .text(
                                response.error_message ||
                                'CSV import failed.'
                            )
                            .removeClass('text-green-600')
                            .addClass('text-red-600');

                        // Stop polling.
                        return;
                    }

                    if (response.status === 'queued') {

                        $('#progressMessage').text(
                            'Waiting for queue worker...'
                        );

                    } else {

                        $('#progressMessage').text(
                            'Import is running...'
                        );
                    }

                    // Schedule next API request.
                    setTimeout(checkImportProgress, pollingInterval);
                },

                error: function() {

                    $('#progressMessage').text(
                        'Unable to retrieve progress. Retrying...'
                    );

                    setTimeout(checkImportProgress, 5000);
                }
            });
        }

        // First request immediately.
        checkImportProgress();

    });
</script>