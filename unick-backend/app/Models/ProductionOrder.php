<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number','sales_order_id','product_id','quantity','status','planned_start_date','planned_end_date','actual_start_date','actual_end_date'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(ProductionStage::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ProductionReport::class);
    }
}
