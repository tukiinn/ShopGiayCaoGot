<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;  // Thêm dòng này

class User extends Authenticatable
{
    use Notifiable;  // Thêm trait Notifiable

    // Các thuộc tính có thể fill
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
