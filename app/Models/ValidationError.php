<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidationError extends Model
{
    protected $fillable = [
        'data_generation_id',
        'error'
    ];
}
