<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataValidation extends Model
{
    protected $fillable = [
        'data_generation_id',
        'template_id',
        'date',
        'time',
        'status',
        'user_id'
    ];

    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }

    public function dataApprovals()
    {
        return $this->hasMany(DataApproval::class);
    }
}
