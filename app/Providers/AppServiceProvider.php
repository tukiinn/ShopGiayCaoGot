<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 

class AppServiceProvider extends ServiceProvider
{




    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;
            $orderCount = 0;
    
            if (Auth::check()) {
                // Đếm số lượng sản phẩm duy nhất trong giỏ hàng của người dùng (distinct product_id)
                $cartCount = Cart::where('user_id', Auth::id())->distinct('product_id')->count('product_id');
                
                // Tính tổng số lượng đơn hàng của người dùng
                $orderCount = Order::where('user_id', Auth::id())->count();
            }
    
            // Chia sẻ cả $cartCount và $orderCount với tất cả các view
            $view->with([
                'cartCount' => $cartCount,
                'orderCount' => $orderCount,
            ]);
        });
    }
}
