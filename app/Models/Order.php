<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $appends = [
        'delivery_date', 'products_count',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }

    public function getDeliveryDateAttribute(): ?string
    {
        return $this->parcels()->max('delivery_date');
    }

    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }
}
