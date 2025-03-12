<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalStage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'data_approval_id',
        'date',
        'time',
        'status',
        'notes'
    ];
}
