<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    // Áp dụng middleware để kiểm tra quyền admin
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Hiển thị danh sách danh mục
    public function categoriesIndex()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị danh mục theo ID
    public function categoriesShow(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // Hiển thị form tạo danh mục mới
    public function categoriesCreate()
    {
        return view('admin.categories.create');
    }

    // Xử lý lưu danh mục mới
    public function categoriesStore(Request $request)
    {
        $request->validate(['name' => 'required|max:255']);
        Category::create($request->all());
        return Redirect::route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    // Hiển thị form chỉnh sửa danh mục
    public function categoriesEdit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Xử lý cập nhật danh mục
    public function categoriesUpdate(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|max:255']);
        $category->update($request->all());
        return Redirect::route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    // Xử lý xóa danh mục
    public function categoriesDestroy(Category $category)
    {
        $category->delete();
        return Redirect::route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    // Hiển thị danh sách sản phẩm
    public function productsIndex()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Hiển thị form tạo sản phẩm mới
    public function productsCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Xử lý lưu sản phẩm mới
    public function productsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng ảnh
        ]);

        // Tạo mới sản phẩm
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Lưu ảnh
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // Di chuyển ảnh vào thư mục /images
            $product->image = $imageName; // Lưu tên ảnh vào cơ sở dữ liệu
        }   

        $product->save(); // Lưu sản phẩm

        return Redirect::route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function productsEdit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Xử lý cập nhật sản phẩm
    public function productsUpdate(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng ảnh
        ]);

        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Lưu ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu cần
            if ($product->image) {
                $imagePath = public_path('images/' . $product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return Redirect::route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Xử lý xóa sản phẩm
    public function productsDestroy(Product $product)
    {
        $product->delete();
        return Redirect::route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    // Hiển thị sản phẩm theo ID
    public function productsShow(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Hiển thị dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
