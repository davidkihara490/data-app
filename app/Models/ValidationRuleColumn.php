<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValidationRuleColumn extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'validation_rule_id',
        'column',
        'rules',
        'in_values'
    ];

    protected $casts = [
        'rules' => 'array',
    ];
}
