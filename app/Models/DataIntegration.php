<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataIntegration extends Model
{
    protected $fillable = [
        'data_generation_id',
        'template_id',
        'date',
        'time',
        'mode',
        'status',
    ];

    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }

    // One DataIntegration has many DataArchivals
    public function dataArchivals()
    {
        return $this->hasMany(DataArchival::class);
    }
}
