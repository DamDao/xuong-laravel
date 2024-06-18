<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->with('variants')->first();
        $colors = ProductColor::pluck('name','id')->all();
        $sizes = ProductSize::pluck('name','id')->all();

        return view('product-detail',compact('product','colors','sizes'));
    }
}
