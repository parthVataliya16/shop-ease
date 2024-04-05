<?php
use Razorpay\Api\Api;

class PaymentGateway
{
    private $apiKey, $secretKey, $api;
    public function __construct()
    {
        global $payment;
        $this->apiKey = $payment['apiKey'];
        $this->secretKey = $payment['secretKey'];
        $this->api = new Api($this->apiKey, $this->secretKey);
    }

    public function payment($amount) {
        $receipt = bin2hex(random_bytes(4));
        $amount = $amount * 100;
        $orderData = [
            'receipt' => $receipt,
            'amount' => $amount,
            'currency' => "INR",
            'payment_capture' => 1
        ];

        $razorpay = $this->api->order->create($orderData);

        $response = [
            'id' => $razorpay->id,
            'apiKey' => $this->apiKey,
            'amount' => $amount
        ];

        header("content-type: application/json");
        return json_encode($response);
    }
}


?>