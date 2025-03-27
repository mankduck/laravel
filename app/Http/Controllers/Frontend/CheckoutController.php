<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\ProductVariant;
use Auth;
use Cookie;
use DB;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

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
            $data['code'] = code_checkout();
            // session(['checkout_data' => $data]);
            if ($data['payment-method'] == 'vnp_payment') {
                $data['status'] = 'confirmed';
                return $this->processVNPayPayment($data);
            }
            $data['status'] = 'pending';
            $this->saveOrder($data);

            DB::commit();
            return redirect()->route('home.index')->with('success', 'Đặt hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    protected function saveOrder($data)
    {
        $checkout = Checkout::create([
            'user_id' => $data['user_id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'description' => $data['description'],
            'payment_method' => $data['payment-method'],
            'total' => $data['total'],
            'product' => $data['product'],
            'status' => $data['status']
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
    }


    protected function processVNPayPayment($data)
    {
        // dd($data);
        // dd(cookie('checkout_data'));

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "OTY91QA9";
        $vnp_HashSecret = "TZMHNTJBMY2BEMN9SM2YZB33W0YFYOPA";

        $vnp_TxnRef = code_checkout();
        $vnp_OrderInfo = "Thanh toán đơn hàng $vnp_TxnRef";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $data['total'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        session(['checkout_data' => $data]);
        session()->save();
        return redirect()->away($vnp_Url);
    }


    public function vnpayReturn(Request $request)
    {

        if ($request->vnp_ResponseCode == '00') {
            DB::beginTransaction();
            try {
                $data = session('checkout_data');
                if (!$data) {
                    return redirect()->route('home.index')->with('error', 'Lỗi: Không tìm thấy đơn hàng trong phiên làm việc.');
                }

                $this->saveOrder($data);
                Cookie::queue(Cookie::forget('checkout_data'));

                DB::commit();
                return redirect()->route('home.index')->with('success', 'Thanh toán VNPay thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('home.index')->with('error', 'Lỗi khi lưu đơn hàng.');
            }
        } else {

            return redirect()->route('home.index')->with('error', 'Thanh toán thất bại.');
        }
    }
}
