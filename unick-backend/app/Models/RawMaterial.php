<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','name','description','unit_of_measure','reorder_point','lead_time_days',
        'stock_on_hand','stock_reserved','preferred_supplier','active'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_materials')
            ->withPivot('quantity_per_unit')
            ->withTimestamps();
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'itemable');
    }
}
