<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'model', 'year', 'type', 'price_per_day', 'availability', 'description', 'images', 'owner_id', 'financial_status'
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'availability' => 'boolean',
        'images' => 'array',
    ];

    /**
     * Get the owner of the vehicle.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Scope a query to only include available vehicles.
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability', true);
    }

    /**
     * Scope a query to filter by vehicle type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by financial status.
     */
    public function scopeWithFinancialStatus($query, $status)
    {
        return $query->where('financial_status', $status);
    }
}
