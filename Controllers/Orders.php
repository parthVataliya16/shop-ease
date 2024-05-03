<?php
class Orders extends Connection
{
    private $status, $sendMail;

    public function __construct()
    {
        parent::__construct();
        $this->sendMail = new SendMail();
    }

    public function allOrders()
    {
        try {
            $allOrders = [];
            $selectOrdersQuery = $this->connection->query("SELECT orders.id, users.first_name, users.last_name, users.phone_number, products.name as product_name, orders.quantity, orders.status 
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
            error('Orders.php', $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'orders' => $allOrders
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }

    function updateOrderStatus($id)
    {
        try {
            $day = $_POST['day'];
            $status = $_POST['status'];
            if ($status == 'accepted') {
                $selectOrderQuery = $this->connection->query("SELECT order_alias.id, product.name, product.price, product.discount, order_alias.quantity, user_alias.email_id 
                FROM orders AS order_alias 
                INNER JOIN products AS product ON product.id = order_alias.product_id INNER JOIN users AS user_alias ON user_alias.id = order_alias.user_id where order_alias.id = $id
                ORDER BY order_alias.id DESC 
                LIMIT 1 OFFSET 0");

                $row = $selectOrderQuery->fetch_assoc();
                $email = $row['email_id'];

                $billNo = $row['id'];
                $quantity = $row['quantity'];
                $productName = $row['name'];
                $discount = $row['price'] * ($row['discount'] / 100) * $quantity;
                $price = ($row['price'] * $quantity)  - $discount;

                $sendMailFrom = 'admin@gmail.com';
                $sendMailTo = $email;
                $subject = 'Order Confirmation';
                $body = "
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        padding: 20px;
                    }
                    .content {
                        display: flex;
                        justify-content: space-evenly;
                    }
                    table {
                        font-family: Arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                    a {
                        display: block;
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    .button:hover {
                        background-color: #0056b3;
                    }
                </style>
                <div class='container'>
                    <a href='http://localhost/project/views/users/orders.php' class='button'>View Your Order</a>
                    <div class='content'>
                        <table>
                            <tr>
                                <td>Bill no.</td>
                                <td>$billNo</td>
                            </tr>
                            <tr>
                                <td>Product name</td>
                                <td>$productName</td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>$quantity</td>
                            </tr>
                            <tr>
                                <td>Delivery Fees</td>
                                <td>- Rs. 40</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>$price</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>$discount</td>
                            </tr>
                        </table>
                    </div>
                </div>";
                $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);
            }
            $this->connection->query("UPDATE orders set status = '$status', delivery_day = '$day' where id = $id");
            $this->status = 200;
        } catch (Exception $error) {
            error("Orders.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }

    function getOrder($id) {
        try {
            $product = [];
            $selectProductQuery = $this->connection->query("SELECT users.first_name, users.last_name, users.phone_number, orders.quantity, orders.payment_option, orders.payment_status, products.name as product_name FROM orders INNER JOIN users ON orders.user_id = users.id INNER JOIN products ON
            orders.product_id = products.id WHERE orders.id = $id;");
            if ($selectProductQuery->num_rows) {
                $row = $selectProductQuery->fetch_assoc();
                $row['user_name'] = $row['first_name'] . " " . $row['last_name'];
                unset($row['first_name']);
                unset($row['last_name']);
                array_push($product, $row);
                $this->status = 200;
            } else {
                $this->status = 400;
            }

        } catch (Exception $error) {
            error("Orders.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'product' => $product,
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>