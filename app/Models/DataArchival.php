<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataArchival extends Model
{
    protected $fillable = [
        'data_generation_id',
        'template_id',
        'date',
        'time',
        'status',
    ];
    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }
}
