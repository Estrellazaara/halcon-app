<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    /**
     * Relationship: An item belongs to an order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: An item belongs to a product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Returns the stock impact based on quantity
     */
    public function subtotalStockImpact(): int
    {
        return $this->quantity;
    }
}