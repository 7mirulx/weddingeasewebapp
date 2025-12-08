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
        'payment_progress',
        'is_completed',
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
}
