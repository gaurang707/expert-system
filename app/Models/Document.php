<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
