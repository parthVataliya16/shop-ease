<?php
class RemoveProductFromCart extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function removeProductFromCart($productId)
    {
        try {
            $userName = $_SESSION['user'];
            $selectUserQuery = $this->connection->query("SELECT id from users where user_name = '$userName' || email_id = '$userName'");

            if ($selectUserQuery->num_rows) {
                $row = $selectUserQuery->fetch_assoc();
                $userId = $row['id'];
                $this->connection->query("DELETE from carts where product_id = $productId && user_id = $userId");

                $this->status = 200;
                $this->message = "Remove product from cart";
            }

        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("RemoveProductFromCart.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header('content-type: application/json');
            return json_encode($response);
        }

    }
}

?>