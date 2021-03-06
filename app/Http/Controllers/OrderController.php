<?php

namespace App\Http\Controllers;

use App\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::getOrderbyCustomer('1');
        dd($order->get());
        // return view('index')->with('order',$order);
    }
}
