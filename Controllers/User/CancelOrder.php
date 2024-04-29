<?php
class CancelOrder extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function cancelOrder($id)
    {
        try {
            $selectProductQuery = $this->connection->query("SELECT user_id, product_id from orders where id = $id");

            if ($selectProductQuery->num_rows) {
                $this->connection->query("DELETE from orders where id = $id");

                $row = $selectProductQuery->fetch_assoc();
                $userID = $row['user_id'];
                $productID = $row['product_id'];

                $selectOrderQuery = $this->connection->query("SELECT id from bags where user_id = $userID && product_id = $productID");

                if (!$selectOrderQuery->num_rows) {
                    $this->connection->query("INSERT into bags (user_id, product_id) values ($userID, $productID) ");
                }

                $this->status = 200;
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            error("CancelOrder.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
}

?>