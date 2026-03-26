<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'name',
        'description',
        'current_stock',
        'minimum_stock'
    ];

    /**
     * Relationship: A product can be included in many order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Increase product stock
     */
    public function increaseStock(int $quantity): void
    {
        $this->increment('current_stock', $quantity);
    }

    /**
     * Decrease product stock
     */
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('current_stock', $quantity);
    }

    /**
     * Check if stock is below minimum level
     */
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }
}