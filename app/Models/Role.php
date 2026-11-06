<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable('name', 'status')]
class Role extends Model
{
    public function casts()
    {
        return [
            'status' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];  
    }

    public function users() 
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
