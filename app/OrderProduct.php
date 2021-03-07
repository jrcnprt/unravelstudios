<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table= 'order_product';

    protected $fillable = ['order_id', 'product_id', 'quantity'];

    public static function getOrderbyCustomer($id)
    {
        return OrderProduct::join('orders', function ($join) {
            $join->on('orders.id', '=', 'order_product.order_id');
        })
        ->leftJoin('products', function ($join) {
            $join->on('products.id', '=', 'order_product.product_id');
        })
        ->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'orders.user_id');
        })
        ->where(['orders.user_id'=>$id])
        ->select(
            'products.name',
            'products.details',
            'products.price',
            'products.description',
            'order_product.quantity',
            'users.name'
        )
        ->get();
    }
}
