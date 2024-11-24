<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // Hiển thị danh sách sản phẩm cho khách hàng
    public function index(Request $request)
    {
        $sort = $request->get('sort');
        $category = $request->get('category');
    
        // Truy vấn sản phẩm với phân trang
        $products = Product::when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })
        ->when($sort, function ($query) use ($sort) {
            if ($sort == 'price_asc') {
                return $query->orderBy('price', 'asc');
            } elseif ($sort == 'price_desc') {
                return $query->orderBy('price', 'desc');
            } elseif ($sort == 'name_asc') {
                return $query->orderBy('name', 'asc');
            } elseif ($sort == 'name_desc') {
                return $query->orderBy('name', 'desc');
            }
        })
        ->paginate(6); // Số sản phẩm trên mỗi trang
    
        // Lấy danh sách danh mục
        $categories = Category::all();
    
        return view('customer.products.index', compact('products', 'categories'));
    }
    

    // Hiển thị chi tiết sản phẩm cho khách hàng
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('customer.products.show', compact('product')); 
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ request

        // Tìm kiếm sản phẩm theo tên hoặc mô tả
        $products = Product::where('name', 'LIKE', "%$query%")
                            ->orWhere('description', 'LIKE', "%$query%")
                            ->paginate(10); // Phân trang kết quả

        // Trả về view hiển thị kết quả tìm kiếm
        return view('customer.products.search_rs', compact('products', 'query'));
    }

}