<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id','stage','status','planned_quantity','actual_quantity','started_at','completed_at'
    ];

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ProductionReport::class, 'stage_id');
    }
}
