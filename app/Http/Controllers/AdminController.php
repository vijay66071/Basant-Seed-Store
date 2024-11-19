<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {
        $orders=Order::orderBy('created_at','DESC')->get()->take(10);
        $dashboardDates=DB::select("SELECT 
                                           SUM(total) AS TotalAmount,
                                           SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                                           SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                                           SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
                                           COUNT(*) AS Total,
                                           SUM(IF(status='ordered', 1, 0)) AS TotalOrdered,
                                           SUM(IF(status='delivered', 1, 0)) AS TotalDelivered,
                                           SUM(IF(status='canceled', 1, 0)) AS TotalCanceled
                                           FROM Orders;
                                    ");
        
        return view('admin.index',compact('orders','dashboardDates'));
    }
    public function brands()
    {
        $brands=Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands',compact('brands'));
    }
    public function add_brand(){
        return view('admin.brand_add');
    }
    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image'=>'mimes:png,jpg,jpeg|max:2048'

        ]);
        $brand=new Brand();
        $brand->name=$request->name;
        $brand->slug=Str::slug($request->name);
        $image=$request->file('image');
        $file_extension=$request->file('image')->extension();
        $file_name=Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateBrandThumbailsImage($image,$file_name);
        $brand->image=$file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been added successfully');
    }
    public function brand_edit($id){
        $brand=Brand::find($id);
        return view('admin.brand-edit',data: compact('brand'));
    }

    public function brand_update(Request $request,){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'image'=>'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand=Brand::find($request->id);
        $brand->name=$request->name;
        $brand->slug=Str::slug($request->name);
        if($request->hasfile('image')){
            if(File::exists(public_path('uploads/brands/').'/'.$brand->image)){
                File::delete(public_path('uploads/brands/').'/'.$brand->image);
            }
            $image=$request->file('image');
            $file_extension=$request->file('image')->extension();
            $file_name=Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateBrandThumbailsImage($image,$file_name);
            $brand->image=$file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been added successfully');
    }
    public function GenerateBrandThumbailsImage($image,$imageName){
        {
            $destinationPath = public_path('uploads/brands');
            $img=Image::read($image->path());
            $img->cover(124,124,"top");
            $img->resize(124,124)->save($destinationPath.'/'.$imageName);
        }
    }

    public function brand_delete($id){
        $brand=Brand::find($id);
        if(File::exists(public_path('uploads/brands/').'/'.$brand->image)){
            File::delete(public_path('uploads/brands/').'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand has been deleted successfully');
    }

    public function categories(){
        $categories=Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories',compact('categories'));
    }
    public function category_add(){
        return view('admin.category_add');
    }
    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image'=>'mimes:png,jpg,jpeg|max:2048'

        ]);
        $category=new Category();
        $category->name=$request->name;
        $category->slug=Str::slug($request->name);
        $image=$request->file('image');
        $file_extension=$request->file('image')->extension();
        $file_name=Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateCategoryThumbailsImage($image,$file_name);
        $category->image=$file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added successfully');
    }
    public function GenerateCategoryThumbailsImage($image,$imageName){
        {
            $destinationPath = public_path('uploads/categories');
            $img=Image::read($image->path());
            $img->cover(124,124,"top");
            $img->resize(124,124)->save($destinationPath.'/'.$imageName);
        }
    }

    public function category_edit($id){
        $category=Category::find($id);
        return view('admin.category-edit',data: compact('category'));
    }
    public function category_update(Request $request)
    {
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,'.$request->id,
                'image'=>'mimes:png,jpg,jpeg|max:2048'
            ]);
            $category=Category::find($request->id);
            $category->name=$request->name;
            $category->slug=Str::slug($request->name);
            if($request->hasfile('image')){
                if(File::exists(public_path('uploads/categories/').'/'.$category->image)){
                    File::delete(public_path('uploads/categories/').'/'.$category->image);
                }
                $image=$request->file('image');
                $file_extension=$request->file('image')->extension();
                $file_name=Carbon::now()->timestamp.'.'.$file_extension;
                $this->GenerateCategoryThumbailsImage($image,$file_name);
                $category->image=$file_name;
            }
            $category->save();
            return redirect()->route('admin.categories')->with('status','Category has been added successfully');    
    }
    public function category_delete($id){
            $category=Category::find($id);
            if(File::exists(public_path('uploads/categories/').'/'.$category->image)){
                File::delete(public_path('uploads/categories/').'/'.$category->image);
            }
            $category->delete();
            return redirect()->route('admin.categories')->with('status','Category has been deleted successfully');
    }
    public function products(){
        $products=Product::orderBy('created_at','DESC')->paginate(10);
        return view('admin.products',compact('products'));
    }
    public function product_add(){
        $categories=Category::select('id','name')->orderBy('name',)->get();
        $brands=Brand::select('id','name')->orderBy('name',)->get();
        return view('admin.product-add',compact('categories','brands'));
    }
    public function product_store(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug',
            'short_description'=>'required',
            'description'=>'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'SKU'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quantity'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg|max:2048',
            'category_id'=>'required',
            'brand_id'=>'required',
        ]);
        $product=new Product();
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->short_description=$request->short_description;
        $product->description=$request->description;
        $product->regular_price=$request->regular_price;
        $product->sale_price=$request->sale_price;
        $product->SKU=$request->SKU;
        $product->stock_status=$request->stock_status;
        $product->featured=$request->featured;
        $product->quantity=$request->quantity;
        $product->category_id=$request->category_id;
        $product->brand_id=$request->brand_id;

        $current_timestamp=Carbon::now()->timestamp;
        
        if($request->hasfile('image')){
            $image=$request->file('image');
            $imageName=$current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbailsImage($image,$imageName);
            $product->image=$imageName;
        }
        $gallery_arr=array();
        $gallery_images="";
        $counter=1;
        if($request->hasfile('images')){
            $allowedfileExtension=['png','jpg','jpeg'];
            $files=$request->file('images');
            foreach($files as $file){
                $gextension=$file->getClientOriginalExtension();
                $gcheck=in_array($gextension,$allowedfileExtension);
                if($gcheck){
                    $gfileName=$current_timestamp."-".$counter.'.'.$file->extension();
                    $this->GenerateProductThumbailsImage($file,$gfileName);
                    array_push($gallery_arr,$gfileName);
                    $counter=$counter+1;
                }
            $gallery_images=implode(",",$gallery_arr);
            }
            $product->images=$gallery_images;
            $product->save();
            return redirect()->route('admin.products')->with('status','Product has been added successfully');
        }
    }
    public function GenerateProductThumbailsImage($image,$imageName){
        {
            $destinationPathThumbnail = public_path('uploads/products/thumbnails');
            $destinationPath = public_path('uploads/products');
            $img=Image::read($image->path());
            $img->cover(540,689,"top");
            $img->resize(540,689)->save($destinationPath.'/'.$imageName);
            $img->resize(104,104)->save($destinationPathThumbnail.'/'.$imageName);
        }
    }

    public function product_edit($id){
        $product=Product::find($id);
        $categories=Category::select('id','name')->orderBy('name',)->get();
        $brands=Brand::select('id','name')->orderBy('name',)->get();
        return view('admin.product-edit',compact('product','categories','brands'));
    }   
    public function product_update(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->id,
            'short_description'=>'required',
            'description'=>'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'SKU'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quantity'=>'required',
            'image'=>'mimes:png,jpg,jpeg|max:2048',
            'category_id'=>'required',
            'brand_id'=>'required',
        ]);
        $product=Product::find($request->id);
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->short_description=$request->short_description;
        $product->description=$request->description;
        $product->regular_price=$request->regular_price;
        $product->sale_price=$request->sale_price;
        $product->SKU=$request->SKU;
        $product->stock_status=$request->stock_status;
        $product->featured=$request->featured;
        $product->quantity=$request->quantity;
        $product->category_id=$request->category_id;
        $product->brand_id=$request->brand_id;

        $current_timestamp=Carbon::now()->timestamp;
        if($request->hasfile('image')){
            if(File::exists(public_path('uploads/products').'/'.$product->image)){
                File::delete(public_path('uploads/products').'/'.$product->image);
            }
            if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)){
                File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
            }
            $image=$request->file('image');
            $imageName=$current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbailsImage($image,$imageName);
            $product->image=$imageName;
        }
        $gallery_arr=array();
        $gallery_images="";
        $counter=1;
        if($request->hasfile('images')){
            foreach(explode(',',$product->images) as $ofile){
                if(File::exists(public_path('uploads/products').'/'.$ofile)){
                    File::delete(public_path('uploads/products').'/'.$ofile);
                }
                if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)){
                    File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                }
            }
            $allowedfileExtension=['png','jpg','jpeg'];
            $files=$request->file('images');
            foreach($files as $file){
                $gextension=$file->getClientOriginalExtension();
                $gcheck=in_array($gextension,$allowedfileExtension);
                if($gcheck){
                    $gfileName=$current_timestamp."-".$counter.'.'.$file->extension();
                    $this->GenerateProductThumbailsImage($file,$gfileName);
                    array_push($gallery_arr,$gfileName);
                    $counter=$counter+1;
                }
            $gallery_images=implode(",",$gallery_arr);
            
            $product->images=$gallery_images;
            }
            $product->save();
            return redirect()->route('admin.products')->with('status','Product has been updated successfully');
        }
    }
    public function product_delete($id){
        $product=Product::find($id);
        if(File::exists(public_path('uploads/products').'/'.$product->image)){
            File::delete(public_path('uploads/products').'/'.$product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)){
            File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
        }
        foreach(explode(",",$product->images) as $image){
            if(File::exists(public_path('uploads/products').'/'.$image)){
                File::delete(public_path('uploads/products').'/'.$image);
            }
            if(File::exists(public_path('uploads/products/thumbnails').'/'.$image)){
                File::delete(public_path('uploads/products/thumbnails').'/'.$image);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status','Product has been deleted successfully');
    }


    public function orders(){
        $orders=Order::orderBy('id','DESC')->paginate(12);
        return view('admin.orders',compact('orders'));
    }
    public function order_details($order_id){
        $order=Order::find($order_id);
        $orderItems=OrderItem::where('order_id',$order_id)->orderBy('id',)->paginate(12);
        $transaction=Transaction::where('order_id',$order_id)->first();
        return view('admin.order-details',compact('order','orderItems','transaction'));
    }
    
}   
