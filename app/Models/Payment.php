<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'price', 
        'transaction_id', 
        'created_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
