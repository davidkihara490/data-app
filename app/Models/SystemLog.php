<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'date',
        'time',
        'status',
        'description',
        'user_id',
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function loggedBy(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
