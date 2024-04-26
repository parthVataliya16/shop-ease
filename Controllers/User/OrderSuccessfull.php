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

                        $this->connection->query("INSERT INTO orders (user_id, product_id) values ($userID, $product[0])");

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
                        $subject = 'Place order';
                        $body = "<a href='http://localhost/practice/project/views/auth/signin.php'> Signin </a>";
                        $body .= "<h5>$user order $productName</h5>";

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