<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('home', compact('products')); // Make sure to return the products
    }
   
}
