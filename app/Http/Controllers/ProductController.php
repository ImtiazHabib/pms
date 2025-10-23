<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
     public function manage_product_page(Request $request){

      $products = Product::with('category');

    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $products->where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }

    $products = $products->paginate(2);

    return view('manage_product', [
        'products' => $products,
    ]);

     }

      public function create_product_page(){

         // read Category 
        $category=  Category::all();
        return view('create_product',[
         'categories' =>$category,
        ]);
     }


      public function edit_product_page($id){
         // check the id 
         $product = Product::with('category')->where('id',$id)->get();

         $categories = Category::all();

         if($product){
            return view('edit_product',[
         'products' => $product,
         'categories' => $categories,
          ]);
         }
        
     }

     public function store_product(ProductRequest $request){
            

            try{
             $request->validated();

            // take information and store
            $product = new Product();

            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;

            // if product image given 
            if($request->hasFile('product_image')){
               $file = $request->file('product_image');
               $file_name = time() . uniqid() . '-' . '.' . $file->getClientOriginalExtension();
               $file_path = "uploads/" . $file_name;
               $file->move(public_path('uploads'),$file_name);
               $product->product_image = $file_path;
            }else{
               $product->product_image = null;
            }

            $product->save();

            return redirect('/manage_product')->with('success',"new Product Added Successfully");

            }catch(Exception $e){
               Log::channel('product_error')->error('Product store Failed ',[
                  'message' =>$e->getMessage(),
                  'line' =>$e->getLine(),
               ]);
            }

     }

     public function update_product(ProductRequest $request){
             try{
             $request->validated();

            $product = Product::where('id',$request->id)->first();

             $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;

            if($request->hasFile('product_image')){
               // delete previous image
               unlink(public_path($product->product_image));

               // and upload new product
               $file = $request->file('product_image');
               $file_name = time() . uniqid() . " ." . $file->getClientOriginalExtension();
               $file_path = "uploads/" . $file_name;
               $file->move(public_path('uploads'),$file_name);
               $product->product_image = $file_path;
             }

             $product->save();

            return redirect('/manage_product')->with('success'," Updated  Successfully");

            }catch(Exception $e){
               Log::channel('product_error')->error('Product update Failed ',[
                  'message' =>$e->getMessage(),
                  'line' =>$e->getLine(),
               ]);
            }
     }

     public function delete_product($id){
        $product =  Product::where('id',$id)->first();

        // delete previous image
               unlink(public_path($product->product_image));

               $product->delete();

             return redirect('/manage_product')->with('success',"Product Deleted Succeffully");

     }
}
