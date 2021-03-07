<?php

namespace App\Http\Controllers;

use App\OrderProduct;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order = OrderProduct::getOrderbyCustomer('1')->take(10);
    }
}
