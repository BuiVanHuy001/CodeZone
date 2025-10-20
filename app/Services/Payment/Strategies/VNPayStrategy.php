<?php

namespace App\Services\Payment\Strategies;

use App\Models\Enrollment;
use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGateWayInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Env;

class VNPayStrategy implements PaymentGateWayInterface
{
    public function createPaymentUrl(Order|array $order): RedirectResponse
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = Env::get('VNP_TMN_CODE');
        $vnp_HashSecret = Env::get('VNP_HASH_SECRET');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = ENV::get('VNPAY_RETURN_URL') . '/vnpay';
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = random_int(1, 10000);
        $amountVnd = (float)$order->total_price;
        $vnp_Amount = (int)round($amountVnd);
        $vnp_Amount *= 100;
        $vnp_BankCode = 'NCB';

        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

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
        return redirect($vnp_Url);
    }

    public function handleCallback(array $data): Redirector|RedirectResponse
    {
        $resultCode = $data['vnp_ResponseCode'] ?? '';
        $orderId = $data['vnp_TxnRef'] ?? null;

        $order = Order::where('id', $orderId)->first();

        if (!$order) {
            return redirect()->route('page.home')->with('swal', [
                'icon' => 'error',
                'title' => 'Payment Error',
                'text' => 'Order not found',
            ]);
        }

        if ($resultCode !== '00') {
            $order->update(['status' => 'failed']);
            return redirect()->route('page.home')->with('swal', [
                'icon' => 'error',
                'title' => 'Payment Failed',
                'text' => 'Your payment could not be processed. Please try again.',
            ]);
        }

        $order->update([
            'status' => 'completed',
            'payment_info' => json_encode($data, JSON_THROW_ON_ERROR),
        ]);

        foreach ($order->items as $item) {
            $item->course->increment('enrollment_count');
            Enrollment::create([
                'user_id' => $order->user_id,
                'course_id' => $item->course->id,
                'status' => 'not_started',
            ]);
        }

        return redirect()->route('page.home')->with('swal', [
            'icon' => 'success',
            'title' => 'Payment Successful',
            'text' => 'Your order has been completed successfully.',
        ]);
    }
}
