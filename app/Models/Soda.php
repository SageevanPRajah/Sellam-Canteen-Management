<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soda extends Model {
    use HasFactory;
    protected $fillable = [
        'product_id',
        'soda_name',
        'brand',
        'size_ml'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
