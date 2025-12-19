<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(VendorRating::class);
    }

    // ADMIN RELATIONSHIPS
    public function ownershipRequests()
    {
        return $this->hasMany(VendorOwnershipRequest::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    protected $table = 'vendors'; // explicit

    protected $fillable = [
        'vendor_name',
        'category',
        'description',
        'email',
        'phone',
        'logo_url',
        'banner_url',
        'gallery',
        'starting_price',
        'city',
        'state',
        'rating_average',
        'rating_count',
        'is_featured',
        'status',
        'created_by_id',
        'created_by_type',
        'featured_start',
        'featured_end',
        'service_ids',
        'owner_user_id',
        'is_paid',
        'rating',
        'claimed_at',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'featured_start' => 'datetime',
        'featured_end' => 'datetime',
        'service_ids' => 'array',
        'is_paid' => 'boolean',
        'claimed_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================
    public function claimTokens()
    {
        return $this->hasMany(VendorClaimToken::class);
    }

    // ==================== METHODS ====================
    public function isClaimed(): bool
    {
        return $this->status !== 'unclaimed';
    }

    public function isUnclaimed(): bool
    {
        return is_null($this->owner_user_id);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function generateClaimToken(): VendorClaimToken
    {
        $token = VendorClaimToken::generateToken();
        
        return $this->claimTokens()->create([
            'token' => $token,
            'expires_at' => now()->addHours(24),
        ]);
    }

    public function getClaimUrl(?VendorClaimToken $token = null): string
    {
        if (!$token) {
            $token = $this->claimTokens()->valid()->first();
        }
        
        if (!$token) {
            return '';
        }

        return route('vendor.claim', ['token' => $token->token]);
    }

}
