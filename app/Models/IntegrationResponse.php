<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationResponse extends Model
{
    protected $fillable = [
        'data_generation_id',
        'response',
    ]
}
