<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $orders = Checkout::orderBy('id', 'DESC')->paginate(10);
        $config = [
            'model' => 'Order'
        ];
        $config['seo'] = __('messages.order');
        return view('backend.order.index', compact('config', 'orders'));
    }
}
