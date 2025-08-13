<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'direction','quantity','reason','moved_at'
    ];

    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
}
