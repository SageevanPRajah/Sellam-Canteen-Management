<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Show extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'time'
    ];

    public function inventories() {
        return $this->hasMany(CanteenInventory::class);
    }
}
