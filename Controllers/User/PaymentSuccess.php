<?php

class PaymentSuccess
{
    private $status, $payment;

    public function __construct()
    {
        $this->payment = new PaymentGateway();
    }

    public function paymentSuccess()
    {
        if ($_POST['razorpay_payment_id']) {
            $orderId = $_POST['razorpay_order_id'];
            $paymentStatus = $this->payment->getPaymentStatus($orderId);

            if ($paymentStatus == 'paid') {
                $this->status = 200;
                header('location: http://localhost/practice/project/views/users/paymentSuccess.php');
                exit;
            } else if ($paymentStatus == 'created') {
                $this->status = 201;
            } else if ($paymentStatus == 'attempted') {
                $this->status == 200;
            } else {
                $this->status = 400;
            }
            header('location: ./../views/users/address.php');
            exit;
        } else {
            echo "Invalid Payment Response!";
        }
    }
}