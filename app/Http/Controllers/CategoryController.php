<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Hiển thị danh sách categories dựa trên role của user
    public function index()
    {
        $categories = Category::all();
      
                return view('customer.categories.index', compact('categories')); // Customer view
          
        }
    // Hiển thị chi tiết của một category dựa trên role của user
    public function show(Category $category)
    {
  return view('customer.categories.show', compact('category')); // Customer view
    }
}