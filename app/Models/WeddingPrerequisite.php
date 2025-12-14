<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPrerequisite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prerequisite_step_id',
        'status',
        'completed_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function step()
    {
        return $this->belongsTo(PrerequisiteStep::class, 'prerequisite_step_id');
    }

    public function documents()
    {
        return $this->hasMany(
            WeddingPrerequisiteDocument::class,
            'wedding_prerequisite_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (Optional but useful)
    |--------------------------------------------------------------------------
    */

    public function isCompleted(): bool
    {
        return in_array($this->status, ['completed', 'approved']);
    }

    public function requiresDocument(): bool
    {
        return (bool) optional($this->step)->requires_document;
    }

    public function isExpired(): bool
    {
        return $this->documents()
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->exists();
    }
}
