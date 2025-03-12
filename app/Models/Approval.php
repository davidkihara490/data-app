<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        // TODO::Add Stage here
        'data_generation_id',
        'date',
        'time',
        'status',
        'notes',
        'user_id',
        'stage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dataGeneration()
    {
        return $this->belongsTo(DataGeneration::class);
    }

    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }
}
