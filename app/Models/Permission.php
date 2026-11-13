<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable('module_id', 'name')]
class Permission extends Model
{
    public function modules(): BelongsTo 
    {
        return $this->belongsTo(Module::class);
    }
}
