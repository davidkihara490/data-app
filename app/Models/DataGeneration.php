<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGeneration extends Model
{
    protected $fillable  = [
        'template_id',
        'date',
        'time',
        'data',
        'status',
        'user_id',
        'validation',
        'approval',
        'integration',
        'archival',
        'processing_date'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function systemLogs()
    {
        return $this->morphMany(SystemLog::class, 'loggable');
    }

    public function dataValidations()
    {
        return $this->hasMany(DataValidation::class);
    }

    public function dataApproval()
    {
        return $this->hasMany(DataApproval::class);
    }

    public function dataIntegration()
    {
        return $this->hasMany(DataIntegration::class);
    }
    public function dataArchival()
    {
        return $this->hasMany(DataArchival::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function approvals()
    {
        return $this->hasMany(Approval::class);
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
    public function validationErrors()
    {
        return $this->hasMany(ValidationError::class);
    }
}
