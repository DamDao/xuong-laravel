<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    public function list()
    {
        // dd(session('cart'));
        $cart = session('cart');
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['quatity'] * ($item['price_sale'] ?: $item['price_regular']);
        }

        return view('cart-list',compact('totalAmount'));
    }

    public function add()
    {
        // dd(request()->all());
        $product = Product::query()->findOrFail(request('product_id'));
        $productVariant = ProductVariant::with(['product_color', 'product_size'])
            // where('product_id',request('product_id'))
            //                                 ->where('size_id',request('size_id'))
            //                                 ->where('color_id',request('color_id'))
            ->where([
                'product_id' => request('product_id'),
                'product_size_id' => request('product_size_id'),
                'product_color_id' => request('product_color_id'),
            ])
            ->firstOrFail();
        // dd($productVariant);

        if (!isset(session('cart')[$productVariant->id])) {

            $data = $product->toArray()
                + $productVariant->toArray()
                + ['quatity' => request('quatity')]; // mare 2 mảng bằng ... or ++
            // dd(    $data['quatity']);
            session()->put('cart.' . $productVariant->id, $data);
        } else {
            $data = session('cart')[$productVariant->id];
            $data['quatity'] = request('quatity');
            session()->put('cart.' . $productVariant->id, $data);
        }
        // dd(session('cart'));
        return redirect()->route('cart.list');
    }
}
