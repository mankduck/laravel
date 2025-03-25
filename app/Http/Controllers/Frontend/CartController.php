<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Models\Cart;
use Auth;
use Illuminate\Http\Request;

class CartController extends FrontendController
{
    public function __construct()
    {

    }

    public function index()
    {
        $seo['meta_title'] = 'Giỏ hàng';
        if (Auth::check()) {
            $user_id = Auth::id(); // Lấy ID người dùng đã đăng nhập
            $cartUser = Cart::where('user_id', $user_id)->get();
            return view('frontend.homepage.cart', compact(
                'cartUser', 'seo'
            ));
        } else {
            return view('frontend.homepage.cart', compact('seo'));
        }
    }
}
