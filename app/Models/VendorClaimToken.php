<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorClaimToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'token',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // ==================== SCOPES ====================
    public function scopeValid($query)
    {
        return $query->whereNull('used_at')
                    ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    // ==================== METHODS ====================
    public function isValid(): bool
    {
        return is_null($this->used_at) && $this->expires_at > now();
    }

    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
