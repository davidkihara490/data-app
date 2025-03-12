<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataApproval extends Model
{
    protected $fillable = [
        'data_validation_id',
        'template_id',
        'date',
        'time',
        'status',
    ];

    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }

    // One DataApproval has many DataIntegrations
    public function dataIntegrations()
    {
        return $this->hasMany(DataIntegration::class);
    }
}
