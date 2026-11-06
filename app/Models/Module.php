<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable('name', 'status', 'description')]
class Module extends Model
{    
    public function casts() 
    {
        return [
            'status' => 'boolean'
        ];
    }

    public function permissions(): HasMany 
    {
        return $this->hasMany(Permission::class);
    }
}
