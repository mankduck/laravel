<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\ProductVariant;
use Auth;
use DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::id(); // Lấy ID người dùng đã đăng nhập
            $cartUser = Cart::where('user_id', $user_id)->get();
            return view('frontend.homepage.checkout', compact(
                'cartUser'
            ));
        } else {
            return view('home.index');
        }
    }

    public function store(CheckoutRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('_token', '_method');
            $checkout = Checkout::create([
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'country' => $data['country'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'email' => $data['email'],
                'description' => $data['description'],
                'payment_method' => $data['payment-method'],
                'product' => $data['product'],
                'status' => 'pending'
            ]);

            Cart::where('user_id', $data['user_id'])->delete();

            foreach ($data['product'] as $item) {
                $quantity = (int) $item[3];
                $uuid = $item[4] ?? null;

                if ($uuid) {
                    $variant = ProductVariant::where('uuid', $uuid)->first();
                    if ($variant) {
                        $variant->decrement('quantity', $quantity);
                    }
                }
            }

            DB::commit();
            return redirect()->route('home.index')->with('success', 'Đặt hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }
}
