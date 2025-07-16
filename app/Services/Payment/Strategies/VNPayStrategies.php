<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGateWayInterface;

class VNPayStrategies implements PaymentGateWayInterface {
    public function createPaymentUrl(Order|array $order, string $method): string
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $order->total_price; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $method; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $inputData = array("vnp_Version" => "2.1.0", "vnp_TmnCode" => env(VNP_TMN_CODE), "vnp_Amount" => $vnp_Amount * 100, "vnp_Command" => "pay", "vnp_CreateDate" => date('YmdHis'), "vnp_CurrCode" => "VND", "vnp_IpAddr" => $vnp_IpAddr, "vnp_Locale" => $vnp_Locale, "vnp_OrderInfo" => "Thanh toan GD: $vnp_TxnRef", "vnp_OrderType" => "other", "vnp_ReturnUrl" => env(VNP_RETURNURL), "vnp_TxnRef" => $vnp_TxnRef, "vnp_ExpireDate" => $expire);

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

        $vnp_Url = env(VNP_URL) . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    public function handleCallback(array $data): mixed
    {
        // Logic to handle VNPay callback
        // This is a placeholder implementation
        return $data;
    }

}
