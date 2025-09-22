<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGateWayInterface;
use Illuminate\Support\Env;
use Random\RandomException;

class VNPayStrategies implements PaymentGateWayInterface
{
    /**
     * @throws RandomException
     */
    public function createPaymentUrl(Order|array $order, string $method): string
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes',
            strtotime($startTime)));

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_HashSecret = Env::get('VNP_HASH_SECRET');
        $vnp_TxnRef = random_int(1, 10000);
        $vnp_Locale = app()->getLocale();
        $vnp_BankCode = $method;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => Env::get('VNP_TMN_CODE'),
            "vnp_Amount" => $order->total_price * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => 'Thanh toan GD:' . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => Env::get('VNP_RETURN_URL'),
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i === 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url .= "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    public function handleCallback(array $data): mixed
    {
        return $data;
    }

}
