<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $documents = Document::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('basic.documents.index', compact('documents'));
    }



    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'documents' => [
                'required',
                'array',
                'min:1',
                'max:5',
            ],
            'documents.*' => [
                'required',
                File::types([
                    'pdf',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                ])->max('5mb'),
            ],
        ], [
            'documents.required' => 'Please select documents.',
            'documents.max' => 'You can upload a maximum of 5 files.',
            'documents.*.max' => 'Each file must be 5 MB or smaller.',
            'documents.*.mimes' => 'Unsupported file format.',
        ]);

        $storedPaths = [];

        try {
            DB::transaction(function () use (
                $validated,
                $request,
                &$storedPaths
            ) {
                foreach ($validated['documents'] as $file) {

                    // Store file in private storage
                    $path = $file->store(
                        'documents',
                        'local'
                    );

                    if ($path === false) {
                        throw new \RuntimeException('File storage failed.');
                    }

                    $storedPaths[] = $path;

                    // Create database record
                    Document::create([
                        'user_id' => $request->user()->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            });
        } catch (Throwable $e) {

            // Remove stored files if upload batch fails
            Storage::disk('local')->delete($storedPaths);

            report($e);

            return back()->withErrors([
                'documents' => 'Unable to upload documents. Please try again.',
            ]);
        }

        return redirect()
            ->route('documents.index')
            ->with('success', 'Documents uploaded successfully.');
    }

    public function download(
        Request $request,
        Document $document
    ): StreamedResponse {

        abort_unless(
            $document->user_id === $request->user()->id,
            403
        );

        abort_unless(
            Storage::disk('local')->exists($document->file_path),
            404
        );

        return Storage::disk('local')->download(
            $document->file_path,
            $document->original_name
        );
    }
}
