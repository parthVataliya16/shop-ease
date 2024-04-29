<?php
class AllOrders extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function allOrders()
    {
        try {
            $allOrders = [];
            $selectOrdersQuery = $this->connection->query("SELECT users.first_name, users.last_name, users.phone_number, products.name as product_name, orders.quantity, orders.status 
            FROM orders
            INNER JOIN users ON users.id = orders.user_id 
            INNER JOIN products ON orders.product_id = products.id;
            ");
            if ($selectOrdersQuery->num_rows) {
                while ($row = $selectOrdersQuery->fetch_assoc()) {
                    $row['user_name'] = $row['first_name'] . " " . $row['last_name'];
                    array_push($allOrders, $row);
                }
                $this->status = 200;
            } else {
                throw new Exception("No order found!", 400);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            error('AllOrders.php', $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'orders' => $allOrders
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>