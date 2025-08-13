<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 'name', 'description', 'unit_of_measure', 'reorder_point', 'lead_time_days',
        'stock_on_hand', 'stock_reserved', 'price', 'active'
    ];

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(RawMaterial::class, 'product_materials')
            ->withPivot('quantity_per_unit')
            ->withTimestamps();
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'itemable');
    }
}
