<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Xóa tất cả người dùng hiện có (nếu cần)
        User::truncate();

        // Tạo một tài khoản admin
        User::create([
            'name' => 'Admin',
            'email' => 'kiintu94@gmail.com',
            'password' => Hash::make('vip9999'),
            'role' => 'admin', 
        ]);
    }
}
