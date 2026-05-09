<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPhoto extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'order_id',
        'type',
        'photo_path',
        'uploaded_by'
    ];

    /**
     * Relationship: A photo belongs to an order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: A photo is uploaded by a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Store the uploaded file and update its path
     */
    public function uploadPhoto($file): void
    {
        $path = $file->store('orders', 'public');
        $this->update(['photo_path' => $path]);
    }
}