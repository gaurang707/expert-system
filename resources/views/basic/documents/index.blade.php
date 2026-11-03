<x-layouts::app :title="__('Multiple File Upload')">

    <div class="max-w-5xl mx-auto py-8 px-4">

        <h1 class="text-2xl font-bold mb-6">
            Multiple Document Upload
        </h1>

        @if(session('success'))
        <div class="p-3 mb-5 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Upload Form -->
        <form method="POST"
            action="{{ route('documents.store') }}"
            enctype="multipart/form-data"
            class="p-6 bg-white border rounded-xl mb-6">

            @csrf

            <label class="block font-medium mb-2">
                Select Documents
            </label>

            <input
                type="file"
                name="documents[]"
                multiple
                accept=".pdf,.doc,.docx,.xls,.xlsx"
                class="w-full border rounded-lg p-3">

            @error('documents')
            <p class="text-red-600 text-sm mt-2">
                {{ $message }}
            </p>
            @enderror

            @foreach($errors->getMessages() as $field => $messages)
            @if(str_starts_with($field, 'documents.'))
            @foreach($messages as $message)
            <p class="text-red-600 text-sm mt-2">
                {{ $message }}
            </p>
            @endforeach
            @endif
            @endforeach

            <p class="text-sm text-gray-500 mt-2">
                Maximum 5 files. Each file must be 5 MB or smaller.
            </p>

            <button
                type="submit"
                class="mt-5 bg-blue-600 text-white px-5 py-2
                   rounded-lg hover:bg-blue-700">
                Upload Documents
            </button>
        </form>

        <!-- Documents List -->
        <div class="bg-white border rounded-xl overflow-x-auto">

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4">File Name</th>
                        <th class="p-4">Size</th>
                        <th class="p-4">Uploaded</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($documents as $document)
                    <tr>
                        <td class="p-4">
                            {{ $document->original_name }}
                        </td>

                        <td class="p-4">
                            {{ number_format($document->file_size / 1024, 2) }} KB
                        </td>

                        <td class="p-4">
                            {{ $document->created_at->format('M d, Y') }}
                        </td>

                        <td class="p-4">
                            <a href="{{ route('documents.download', $document) }}"
                                class="text-blue-600 hover:underline">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4"
                            class="p-6 text-center text-gray-500">
                            No documents uploaded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $documents->links() }}
        </div>
    </div>

</x-layouts::app>