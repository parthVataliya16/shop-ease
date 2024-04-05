<?php
class PlaceOrder
{
    private $status, $order;
    public function __construct()
    {
        $this->order = new PaymentGateway();
    }

    public function placeOrder()
    {
        $amount = (int) (substr($_POST['amount'], 3)) + 20;
        $orderId = $this->order->payment($amount);
        return $orderId;
    }
}

?>