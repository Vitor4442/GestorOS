<?php

namespace App\Models;

use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Database\Factories\ServiceOrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['number', 'customer_id', 'assigned_to', 'title', 'description', 'status', 'priority', 'scheduled_at', 'completed_at', 'estimated_cost', 'final_cost'])]
class ServiceOrder extends Model
{
    /** @use HasFactory<ServiceOrderFactory> */
    use HasFactory;

    protected $attributes = [
        'status' => ServiceOrderStatus::Open->value,
        'priority' => ServiceOrderPriority::Normal->value,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedTechnician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ServiceOrderUpdate::class);
    }

    protected function casts(): array
    {
        return [
            'status' => ServiceOrderStatus::class,
            'priority' => ServiceOrderPriority::class,
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_cost' => 'decimal:2',
            'final_cost' => 'decimal:2',
        ];
    }
}
