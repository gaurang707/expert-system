<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsvImport extends Model
{
    protected $fillable = [
        'user_id',
        'file_name',
        'status',
        'total_rows',
        'processed_rows',
        'success_rows',
        'failed_rows',
        'error_message',
        'started_at',
        'completed_at'
    ];

    
}
