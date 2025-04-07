<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
        'stock_count',
        'original_price',
        'selling_price',
        'category',
        'description'
    ];

    public function soda() {
        return $this->hasOne(Soda::class);
    }

    public function inventories() {
        return $this->hasMany(CanteenInventory::class);
    }
}
