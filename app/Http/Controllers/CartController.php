<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    
    public function index()
    {
         // Kiểm tra xem người dùng đã đăng nhập chưa
         if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->with('product')->get();
        
        // Kiểm tra xem số lượng trong giỏ có vượt quá số lượng tồn kho không
        $isOutOfStock = false;
        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->quantity) {
                $isOutOfStock = true;
                break;
            }
        }

        return view('customer.cart.index', compact('carts', 'isOutOfStock'));
    }
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $productId)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }
    
        $userId = Auth::id();
        $product = Product::find($productId);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không hợp lệ.');
        }
    
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
    
        if ($cart) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
            $cart->quantity += 1;
            $cart->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
    
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    

   // Cập nhật số lượng sản phẩm trong giỏ hàng
   public function updateCart(Request $request, $cartId)
   {
       $userId = Auth::id();
       $cart = Cart::where('id', $cartId)->where('user_id', $userId)->first();

       if (!$cart) {
           return redirect()->back()->with('error', 'Item Giỏ hàng trống.');
       }

       $product = $cart->product;

       // Kiểm tra nếu số lượng cập nhật vượt quá số lượng trong kho
       if ($request->quantity > $product->quantity) {
           return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ trong kho.');
       }

       $cart->quantity = $request->quantity;
       $cart->save();

       return redirect()->back();

   }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($cartId)
    {
        $userId = Auth::id();
        $cart = Cart::where('id', $cartId)->where('user_id', $userId)->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Item Giỏ hàng trống');
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã bị xóa khỏi giỏ hàng.');
    }

    // Xóa tất cả sản phẩm trong giỏ hàng
    public function clearCart()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thực hiện thao tác này.');
        }
        Cart::where('user_id', $userId)->delete();
        return redirect()->back()->with('success', 'Đã xóa toàn bộ sản phẩm trong giỏ hàng.');
    }
    
}
