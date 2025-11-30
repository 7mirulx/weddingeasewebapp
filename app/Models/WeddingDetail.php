<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_name',
        'wedding_date',
        'preference_priority',
        'wedding_theme',
        'wedding_size',
        'budget',
        'venue_state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
