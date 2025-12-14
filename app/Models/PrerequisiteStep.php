<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrerequisiteStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'requires_document',
        'requires_expiry',
        'step_order',
    ];

    public function prerequisites()
    {
        return $this->hasMany(
            WeddingPrerequisite::class,
            'prerequisite_step_id'
        );
    }
}
