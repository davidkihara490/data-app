<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'frequecny',
        'table',
        'submission_type'
    ];

    public function dataGenerations()
    {
        return $this->hasMany(DataGeneration::class);
    }
    public function latestDataGeneration()
    {
        return $this->hasOne(DataGeneration::class)->latest();
    }

    public function latestValidation()
    {
        return $this->hasOne(DataValidation::class)->latest();
    }

    public function latestApproval()
    {
        return $this->hasOne(DataApproval::class)->latest();
    }

    public function latestIntegration()
    {
        return $this->hasOne(related: DataIntegration::class)->latest();
    }

    public function latestArchival()
    {
        return $this->hasOne(DataArchival::class)->latest();
    }

    public function workFlow(){
        return $this->hasOne(WorkFlow::class)->latest();
    }
    public function validationRule(){
        return $this->hasOne(ValidationRule::class)->latest();
    }
}
