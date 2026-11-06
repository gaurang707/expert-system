<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable('name', 'status')]
class RoleUser extends Model
{
    public function casts()
    {
        return [
            'boolean' => 'status'
        ];
    }

    

}
