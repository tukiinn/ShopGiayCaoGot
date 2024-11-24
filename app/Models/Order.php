<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'address', 'phone', 'payment_method', 'total_price', 'status','request_cancel'];

    /**
     * Mối quan hệ với thanh toán (Payment)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
{
    return $this->belongsTo(User::class, 'user_id'); // Giả sử khách hàng được lưu trong bảng users
}

public function products()
{
    return $this->belongsToMany(Product::class)->withPivot('quantity');
}



}
