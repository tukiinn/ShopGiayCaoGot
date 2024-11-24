<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'quantity', 'price', 'category_id', 'image',
    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
     // Định nghĩa mối quan hệ nhiều-nhiều với Order
     public function orders()
     {
         return $this->belongsToMany(Order::class)->withPivot('quantity');
     }
    
}

