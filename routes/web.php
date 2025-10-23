<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/manage_product',[ProductController::class,'manage_product_page'])->name('manage_product_page');
Route::get('/create_product',[ProductController::class,'create_product_page'])->name('create_product_page');
Route::post('/edit_product/{id}',[ProductController::class,'edit_product_page'])->name('edit_product_page');

Route::post('/store_product',[ProductController::class,'store_product'])->name('store_product');
Route::post('/update_product',[ProductController::class,'update_product'])->name('update_product');
Route::post('/delete_product/{id}',[ProductController::class,'delete_product'])->name('delete_product');

Route::get('/search',function(Request $request){
    $query = Product::query();
    
    $name = $request->query('name');
    $query->when($name, function($querys,$name){
        return $querys->where('name','like',"%{$name}%");
    })->paginate(2);
    

    return $query;
});

