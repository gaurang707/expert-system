<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('name', 'slug')]
class Module extends Model
{
    public function permissions() 
    {
        return $this->hasMany(Permission::class);
    }
}
