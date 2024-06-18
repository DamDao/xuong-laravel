<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_ORDER = [
        'pending'               => 'chờ xác nhận',
        'confirmend'            => 'đã xác nhận',
        'preparing_goods'       => 'đang chuẩn bị hàng',
        'shipping'              => 'đang vận chuyển',
        'delivered'             => 'đã giao hàng',
        'canceled'              => 'đơn đã hàng bị hủy',
    ];

    const STATUS_PAYMENT = [
        'unpaid'               => 'chưa thanh toán',
        'paid'                 => 'đã thanh toán',
    ];


    const STATUS_ORDER_PENDING = 'pending';
    const STATUS_ORDER_CONFIRMEND = 'đã xác nhận';
    const STATUS_ORDER_PREPARING_GOODS = 'đang chuẩn bị hàng';
    const STATUS_ORDER_SHIPPING = 'đang vận chuyển';
    const STATUS_ORDER_DELIVERED = 'đã giao hàng';
    const STATUS_ORDER_CANCELED = 'đơn đã hàng bị hủy';
    const STATUS_PAYMENT_UNPAID = 'chưa thanh toán';
    const STATUS_PAYMENT_PAID = 'đã thanh toán';


    protected $fillable = [
        'user_id',
        'product_variant_id',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_note',
        'is_ship_user_same_user',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_note',
        'status_order',
        'status_payment',
        'total_price',
    ];
}
