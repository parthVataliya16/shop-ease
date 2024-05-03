<?php

class OrderSuccessfull extends Connection
{
    private $status, $sendMail;

    public function __construct()
    {
        parent::__construct();
        $this->sendMail = new SendMail();
    }

    public function orderSuccessfull()
    {
        try {
            $productQuantity = $_POST['quantity'];
            $paymentOption = $_POST['paymentOption'];
            $address = $_POST['address'];

            $productQuantity = json_decode($productQuantity);
            foreach($productQuantity as $product) {
                $selectCurrentQuantityQuery = $this->connection->query("SELECT quantity from products where id = $product[0]");
                if ($selectCurrentQuantityQuery->num_rows) {
                    $currenQuantity = $selectCurrentQuantityQuery->fetch_assoc();
                    $currenQuantity = $currenQuantity['quantity'];
    
                    if ($currenQuantity > 0) {
                        $updateQuantity = $currenQuantity - $product[1];
                    } else {
                        throw new Exception("Product is out of stock" , 400);
                    }
                    $this->connection->query("UPDATE products set quantity = $updateQuantity where id = $product[0]");
                    $selectUserQuery = $this->connection->query("SELECT user_id from bags where product_id = $product[0]");
                    if ($selectUserQuery->num_rows) {
                        $userID = $selectUserQuery->fetch_assoc();
                        $userID = $userID['user_id'];
                        $this->connection->query("DELETE from bags where product_id = $product[0] && user_id = $userID");

                        $paymentStatus = $paymentOption === 'cod' ? "pending" : "Successfull";

                        $this->connection->query("INSERT INTO orders (user_id, product_id, quantity, payment_option, payment_status, address_id) values ($userID, $product[0], $product[1], '$paymentOption', '$paymentStatus', $address)");

                        $user = $_SESSION['user'];

                        $selectMailOfUserQuery = $this->connection->query("SELECT email_id from users where email_id = '$user' || user_name = '$user'");
                        $email = $selectMailOfUserQuery->fetch_assoc();
                        $email = $email['email_id'];

                        $selectAdminEmailQuery = $this->connection->query("SELECT email_id from users where id = 1");
                        $adminEmail = $selectAdminEmailQuery->fetch_assoc();
                        $adminEmail = $adminEmail['email_id'];

                        $selectProductNameQuery = $this->connection->query("SELECT name from products where id = $product[0]");
                        $productName = $selectProductNameQuery->fetch_assoc();
                        $productName = $productName['name'];
                        
                        $sendMailFrom = $email;
                        $sendMailTo = $adminEmail;
                        $subject = 'New Order Notification<';
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
                            .order-details {
                                background-color: #f4f4f4;
                                padding: 10px;
                                border-radius: 5px;
                            }
                            .btn {
                                display: inline-block;
                                padding: 10px 20px;
                                background-color: #007bff;
                                color: #fff;
                                text-decoration: none;
                                border-radius: 5px;
                            }
                            .btn:hover {
                                background-color: #0056b3;
                            }
                        </style>
                        <div class='container'>
                            <p>Hello Admin,</p>
                            <p>A new order has been placed by the user <strong>$user</strong>. The user ordered the following product:</p>
                            <div class='order-details'>
                                <p><strong>Product Name:</strong> $productName</p>
                            </div>
                            <p>Thank you for your attention.</p>
                            <p>If you want to view the order details, please sign in to the admin dashboard:</p>
                            <a href='http://localhost/practice/project/views/auth/signin.php' class='btn'>Sign In to Admin Dashboard</a>
                            <p>Best regards,<br>Shop ease Team</p>
                        </div>";
                        
                        $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);

                        $this->status = 200;
                    } else {
                        throw new Exception("No user found!" , 400);
                    }
                } else {
                    throw new Exception("No product found!" , 400);
                }
            }
        } catch (Exception $error) {
            error("OrderSuccessfull.php", $error->getCode(), $error->getMessage(), $error->getLine());
        }

        return $this->status;
    }
}