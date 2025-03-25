<?php

namespace App\Http\ViewComposers;

use App\Models\Cart;
use Auth;
use Illuminate\View\View;

class CartComposer
{
    public function __construct(
    ) {
    }
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user_id = Auth::id(); // Lấy ID người dùng đã đăng nhập
            $countCartUser = Cart::where('user_id', $user_id)->count();
        } else {
            $countCartUser = 0; // Nếu chưa đăng nhập, giỏ hàng = 0
        }

        $view->with('countCartUser', $countCartUser);
    }

}