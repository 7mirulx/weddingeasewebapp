<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPrerequisiteDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_prerequisite_id',
        'type',
        'file_path',
        'original_name',
        'uploaded_at',
        'expires_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function prerequisite()
    {
        return $this->belongsTo(
            WeddingPrerequisite::class,
            'wedding_prerequisite_id'
        );
    }
}
