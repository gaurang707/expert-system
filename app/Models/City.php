<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('country_id', 'name')]
class City extends Model
{
    protected $table = 'cities';
}
