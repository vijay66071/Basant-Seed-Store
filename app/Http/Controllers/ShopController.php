<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index(Request $request){
        $size=$request->query('size')? $request->query('size'):12;
        $products=Product::orderBy('created_at','DESC')->paginate(3);
        return view('shop',compact('products','size'));
    }

    public function product_details($product_slug){
        $product=Product::where('slug',$product_slug)->first();
        $rproduct=Product::where('slug','<>',$product_slug)->get()->take(8);
        return view('details',compact('product','rproduct'));
    }

}
