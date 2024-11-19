<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
class HomeController extends Controller
{
   
    public function index()
    {
        $categories=Category::orderBy('name')->get()->take(2);
        $fproducts=Product::where('featured',1)->get()->take(8);
        return view('index',compact('categories','fproducts'));
    }
}
