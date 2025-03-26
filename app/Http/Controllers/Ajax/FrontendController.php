<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartModel;
use DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct(
    ) {
    }

    public function addToCart(Request $request)
    {

        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $query = Cart::where('user_id', $data['user_id']);

            if (!empty($data['sku'])) {
                // Nếu có SKU, kiểm tra xem user_id đã có SKU chưa
                $query->where('sku', $data['sku']);
            } else {
                // Nếu không có SKU, kiểm tra user_id và product_id
                $query->where('product_id', $data['productId']);
            }
            $cartItem = $query->first();

            if ($cartItem) {
                // Nếu tồn tại, cập nhật số lượng
                $cartItem->update([
                    'total' => $cartItem->total += $data['total'],
                ]);
                $type = 'update';
            } else {
                // Nếu chưa tồn tại, tạo mới
                Cart::create([
                    'user_id' => $data['user_id'],
                    'product_id' => $data['productId'],
                    'attribute_name' => $data['attributeName'],
                    'price' => $data['price'],
                    'total' => $data['total'],
                    'quantity' => $data['quantity'],
                    'image' => $data['image'],
                    'sku' => $data['sku'], // Nếu không có SKU thì để null
                ]);
                $type = 'create';
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => $type,
                'message' => 'Thêm giỏ hàng thành công!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function removeCart(Request $request)
    {
        $id = $request->only('id');
        Cart::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xoá khỏi giỏ hàng thành công!',
        ]);
    }

    public function updateTotalCart(Request $request)
    {
        $data = $request->only('id', 'total');
        $query = Cart::where('id', $data['id'])->update([
            'total' => $data['total'],
        ]);

        if($query){
            return response()->json([
                'status' => true,
                'message' => 'Thành công!',
            ]);
        }
    }
}
