<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function save()
    {
        try {
            DB::transaction(function () {
                $user = User::create([
                    'name' => \request('user_name'),
                    'email' => \request('user_email'),
                    'password' => bcrypt(\request('user_email')),
                    'is_active' => false,

                ]);
// dd($user);
                $cart = session('cart');
                $totalAmount = 0;
                $dataItem = [];
                // dd($cart);
                foreach ($cart as $variantID => $item) {
                    $totalAmount += $item['quatity'] * ($item['price_sale'] ?: $item['price_regular']);
                    $dataItem[] = [
                        'product_variant_id' => $variantID,
                        'quantity' => $item['quatity'],
                        'product_name' => $item['name'],
                        'product_sku' => $item['sku'],
                        'product_img_thumbnail' => $item['img_thumbnail'],
                        'product_price_regular' => $item['price_regular'],
                        'product_price_sale' => $item['price_sale'],
                        'variant_size_name' => $item['product_size']['name'],
                        'variant_color_name' => $item['product_color']['name'],
                    ];
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => \request('user_phone'),
                    'user_address' => \request('user_address'),
                    'total_price' => $totalAmount,

                ]);

                foreach ($dataItem as $item) {
                    $item['order_id'] = $order->id;

                    OrderItem::create($item);
                }
            });

            session()->forget('cart');

            return redirect()->route('welcome')->with('success', 'Đặt hàng thành công');
        } catch (\Exception $exception) {
            // dd($exception->getMessage());
            return back()->with('error', 'Lỗi đặt hàng');
        }
    }
}
