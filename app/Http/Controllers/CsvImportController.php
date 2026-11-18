<?php

namespace App\Http\Controllers;

use App\Models\CsvImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CsvImportController extends Controller
{
    public function show(CsvImport $csvImport): View
    {
        abort_unless(
            $csvImport->user_id === auth()->id(),
            403
        );

        return view('inter.admin.csv-import-progress', [
            'import' => $csvImport,
        ]);
    }

    public function status(CsvImport $csvImport): JsonResponse
    {
        abort_unless(
            $csvImport->user_id === auth()->id(),
            403
        );

        $total = $csvImport->total_rows;
        $processed = $csvImport->processed_rows;

        $percentage = $total > 0
            ? min(100, round(($processed / $total) * 100, 2))
            : 0;

        return response()->json([
            'id' => $csvImport->id,
            'file_name' => $csvImport->file_name,
            'status' => $csvImport->status,

            'total_rows' => $total,
            'processed_rows' => $processed,
            'success_rows' => $csvImport->success_rows,
            'failed_rows' => $csvImport->failed_rows,
            'remaining_rows' => max(0, $total - $processed),

            'percentage' => $percentage,
            'error_message' => $csvImport->error_message,
        ])->header('Cache-Control', 'no-store');
    }
}
