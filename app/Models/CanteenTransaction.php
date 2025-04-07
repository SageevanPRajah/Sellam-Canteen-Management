<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CanteenTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit',
        'debit',
        'balance',
        'transaction_type',
        'username',
        'inside_transaction',
        'description'
    ];
}
