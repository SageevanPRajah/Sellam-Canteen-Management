<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CanteenInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'show_id',
        'product_id',
        'initial_stock',
        'refill_stock',
        'final_stock'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function show() {
        return $this->belongsTo(Show::class);
    }

    // Sold count: (initial_stock + refill_stock) - final_stock
    public function getSoldCountAttribute() {
        $refill = $this->refill_stock ?? 0;
        return ($this->initial_stock + $refill) - $this->final_stock;
    }
}
