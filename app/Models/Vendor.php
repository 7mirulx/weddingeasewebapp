<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
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
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'featured_start' => 'datetime',
        'featured_end' => 'datetime',
        'service_ids' => 'array',
    ];
}
