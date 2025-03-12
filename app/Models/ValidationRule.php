<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValidationRule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'template_id'
    ];

    public function validationRuleColumns()
    {
        return $this->hasMany(ValidationRuleColumn::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
