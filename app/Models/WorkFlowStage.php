<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkFlowStage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'work_flows_id',
        'user_id',
        'stage'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
