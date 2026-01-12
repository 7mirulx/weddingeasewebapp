<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'status',
        'payment_progress',
        'is_completed',
        'agreed_price',
    ];

    protected $casts = [
        'payment_progress' => 'array',
        'is_completed' => 'boolean',
    ];

    // ---------------------------
    // RELATIONSHIPS
    // ---------------------------

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function rating()
    {
        return $this->hasOne(VendorRating::class);
    }

    public function weddingDetails()
    {
        return $this->user->weddingDetails();
    }

    /**
     * Get days until wedding date
     */
    public function getDaysUntilWedding()
    {
        $weddingDate = $this->user->weddingDetails?->wedding_date;
        if (!$weddingDate) {
            return null;
        }
        
        return (int) now()->diffInDays(\Carbon\Carbon::parse($weddingDate), false);
    }
}
