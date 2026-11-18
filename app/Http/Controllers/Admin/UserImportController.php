<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportUsersRequest;
use App\Jobs\ProcessUserCsvImport;
use App\Models\User;
use App\Services\ImportCsvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserImportController extends Controller
{

    public function __construct(public ImportCsvService $csvService) {}

    public function index()
    {
        return view('inter.admin.import');
    }

    public function indexqueue()
    {
        return view('inter.admin.importqueue');
    }


    

    public function store(ImportUsersRequest $request)
    {
        $validated = $request->validated();

        // Store uploaded file in private storage.
        $path = $validated['csv_file']
            ->store('csv-imports', 'local');

        ProcessUserCsvImport::dispatch($path)->onQueue('csv-imports');

        return redirect()
            ->back()
            ->with('success', 'CSV import has been queued for processing.');



        $hashPassword = Hash::make('password');
        $file = $request->file('csv_file');


        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return back()->withErrors([
                'csv_file' => 'Unable to read CSV file.',
            ]);
        }

        $rows = [];
        $errors = [];
        $seenEmails = [];

        try {
            // Step 2: Read CSV header
            $header = fgetcsv($handle, 0, ',', '"', '');

            if (!$header) {
                return back()->withErrors([
                    'csv_file' => 'CSV file is empty.',
                ]);
            }

            // Remove UTF-8 BOM if present
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

            $header = array_map('trim', $header);

            if ($header !== ['name', 'email', 'status']) {
                return back()->withErrors([
                    'csv_file' =>
                    'Invalid CSV headers. Expected: name,email,status',
                ]);
            }

            $rowNumber = 1;

            // Step 3: Validate each CSV row
            while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {

                $rowNumber++;

                if (count($row) === 1 && trim($row[0]) === '') {
                    continue;
                }

                if ($rowNumber > 1001) {
                    $errors[] = 'CSV cannot contain more than 1000 data rows.';
                    break;
                }

                if (count($row) !== count($header)) {
                    $errors[] = "Row {$rowNumber}: Invalid column count.";
                    continue;
                }

                $data = array_combine($header, $row);

                $data = array_map('trim', $data);

                $data['email'] = strtolower($data['email']);

                $validator = Validator::make($data, [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                    ],

                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users', 'email'),
                    ],

                    'status' => [
                        'required',
                        Rule::in(['active', 'inactive']),
                    ],
                ]);

                if ($validator->fails()) {

                    foreach ($validator->errors()->all() as $message) {
                        $errors[] = "Row {$rowNumber}: {$message}";
                    }

                    continue;
                }

                // Step 4: Check duplicate emails within CSV
                if (in_array($data['email'], $seenEmails, true)) {

                    $errors[] = "Row {$rowNumber}: Duplicate email in CSV.";

                    continue;
                }

                $seenEmails[] = $data['email'];

                $rows[] = $data;
            }
        } finally {
            fclose($handle);
        }

        // Step 5: Return validation errors
        if (!empty($errors)) {

            return back()->with([
                'import_errors' => $errors,
            ]);
        }

        if (empty($rows)) {
            return back()->withErrors([
                'csv_file' => 'No valid data rows found.',
            ]);
        }


        $chunkSize = 100;
        $importedCount = 0;

        $now = now();

        // Step 6: Insert only after all rows pass validation
        DB::transaction(function () use (
            $rows,
            $chunkSize,
            $now,
            $hashPassword,
            &$importedCount
        ) {

            foreach (array_chunk($rows, $chunkSize) as $chunk) {

                $users = [];

                foreach ($chunk as $row) {

                    $users[] = [
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'status' => $row['status'],
                        'password' => $hashPassword,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                DB::table('users')->insert($users);
                $importedCount += count($users);
            }
        });

        return back()->with(
            'success',
            count($rows) . ' users imported successfully.'
        );
    }

    public function storequeue(ImportUsersRequest $request)
    {
        $validated = $request->validated();

        // Store uploaded file in private storage.
        $path = $validated['csv_file']
            ->store('csv-imports', 'local');


            //ProcessUserCsvImport::dispatchSync($path);
            ProcessUserCsvImport::dispatch($path)->onQueue('csv-imports');

        return redirect()
            ->back()
            ->with('success', 'CSV import has been queued for processing.');

    }
}
