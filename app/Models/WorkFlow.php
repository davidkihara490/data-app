<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkFlow extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'template_id',
        'stages'
    ];

    public function approvalStages()
    {
        return $this->hasMany(WorkFlowStage::class);
    }

    public function template(){
        return $this->belongsTo(Template::class);
    }
}
