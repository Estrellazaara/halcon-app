<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_number',
        'fiscal_data',
        'delivery_address',
        'scheduled_delivery_date',
        'order_datetime',
        'notes',
        'status',
        'is_deleted',
        'created_by'
    ];

    // Attribute casting
    protected $casts = [
        'order_datetime' => 'datetime',
        'scheduled_delivery_date' => 'datetime',
        'is_deleted' => 'boolean'
    ];

    /**
     * Relationship: An order belongs to a user (creator)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: An order has many items (products)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship: An order has many photos
     */
    public function photos(): HasMany
    {
        return $this->hasMany(OrderPhoto::class);
    }

    /**
     * Add a product to the order
     */
    public function addItem(Product $product, int $quantity)
    {
        return $this->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
    }

    /**
     * Change order status if the transition is valid
     */
    public function changeStatus(string $newStatus): void
    {
        if ($this->canTransitionTo($newStatus)) {
            $this->update(['status' => $newStatus]);
        }
    }

    /**
     * Validate if the status transition is allowed
     */
    public function canTransitionTo(string $newStatus): bool
    {
        $flow = [
            'Ordered' => 'In process',
            'In process' => 'In route',
            'In route' => 'Delivered'
        ];

        return isset($flow[$this->status]) && $flow[$this->status] === $newStatus;
    }

    /**
     * Mark the order as logically deleted
     */
    public function markAsDeleted(): void
    {
        $this->update(['is_deleted' => true]);
    }

    /**
     * Restore a logically deleted order
     */
    public function restore(): void
    {
        $this->update(['is_deleted' => false]);
    }
}