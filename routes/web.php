<?php

use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $products = Product::latest('id')->limit(4)->get();
    return view('welcome', compact('products'));
});

// Route::get('cart-add/{productID}/{quantity}',[CartController::class,'add'])->name('cart.add');
Route::get('product/{slug}',[ProductController::class,'detail'])->name('product.detail');
Route::get('cart/list',[CartController::class,'list'])->name('cart.list');
Route::post('cart/add',[CartController::class,'add'])->name('cart.add');
Route::post('order/save',[CartController::class,'order'])->name('order.save');
