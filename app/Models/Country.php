<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('name', 'iso2')]
class Country extends Model
{
    protected $table = "country";

    public function cities() 
    {
        return $this->hasMany(City::class);
    }
}


