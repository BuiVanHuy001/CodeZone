<?php

namespace App\Services\Payment\Strategies;

use App\Models\Enrollment;
use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGateWayInterface;
use App\Support\MomoResultCodes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Env;

class MomoStrategy implements PaymentGateWayInterface
{
    public function createPaymentUrl(Order $order): Redirector|RedirectResponse
    {
        $endpoint = Env::get('MOMO_API_ENDPOINT');

        $partnerCode = Env::get('MOMO_PARTNER_CODE');
        $accessKey = Env::get('MOMO_ACCESS_KEY');
        $secretKey = Env::get('MOMO_SECRET_KEY');
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "" . (int)$order->total_price;
        $orderId = time() . "";
        $redirectUrl = Env::get('MOMO_RETURN_URL');
        $ipnUrl = Env::get('MOMO_RETURN_URL');
        $extraData = json_encode(['cartId' => $order->id], JSON_THROW_ON_ERROR);

        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult["payUrl"]);
        }

        return redirect()->back()->with('swal', [
            'icon' => 'error',
            'title' => 'Payment Error',
            'text' => $jsonResult['message'] ?? 'Unknown error',
        ]);
    }

    private function execPostRequest(string $url, string $data): bool|string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function handleCallback(array $data): Redirector|RedirectResponse
    {
        $resultCode = (int)$data['resultCode'];
        $extraData = json_decode($data['extraData'], true, JSON_THROW_ON_ERROR, JSON_THROW_ON_ERROR);
        $order = Order::find($extraData['cartId']);

        if ($resultCode !== 0) {
            $order->update(['status' => 'failed']);
            return redirect()->route('page.home')->with('swal', [
                'icon' => 'error',
                'title' => 'Payment Failed',
                'text' => MomoResultCodes::get($resultCode),
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
