<?php

namespace App\Services\Payment\Strategies;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGateWayInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Env;
use Random\RandomException;

class VNPayStrategy implements PaymentGateWayInterface
{
    public function createPaymentUrl(Order|array $order): RedirectResponse
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = Env::get('VNP_TMN_CODE'); //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = Env::get('VNP_HASH_SECRET'); //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $amountVnd = (float)$order->total_price; // 1758000.000
        $vnp_Amount = (int)round($amountVnd);     // chỉ còn 1758000
        $vnp_Amount *= 100;
        $vnp_BankCode = 'NCB'; //Mã Ngân hàng thanh toán

        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

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

    public function handleCallback(array $data): mixed
    {
        return $data;
    }

}
