<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'delivery_date', 'carrier',
    ];

    protected $appends = [
        'products_count', 'weight',
    ];

    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    public function getWeightAttribute(): float
    {
        return round($this->products()->sum('weight'), 2);
    }
}
