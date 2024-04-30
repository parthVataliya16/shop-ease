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

                        $this->connection->query("INSERT INTO orders (user_id, product_id, quantity) values ($userID, $product[0], $product[1])");

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
                        
                        // $selectOrderQuery = $this->connection->query("SELECT order_alias.id, product.name, product.price, product.discount 
                        // FROM orders AS order_alias 
                        // INNER JOIN products AS product ON product.id = order_alias.product_id 
                        // ORDER BY order_alias.id DESC 
                        // LIMIT 1 OFFSET 0;");

                        // $row = $selectOrderQuery->fetch_assoc();
                        // $billNo = $row['id'];
                        // $productName = $row['name'];
                        // $discount = $row['price'] * ($row['discount'] / 100) * $product[1];
                        // $price = ($row['price'] * $product[1])  - $discount;

                        // $sendMailFrom = $adminEmail;
                        // $sendMailTo = $email;
                        // $subject = 'Your Order Place successfully';
                        // $body = "
                        // <style>
                        //     .content {
                        //         display: flex;
                        //         justify-content: space-evenly;
                        //     }
                        //     table {
                        //         font-family: arial, sans-serif;
                        //         border-collapse: collapse;
                        //         width: 100%;
                        //     }
                
                        //     td, th {
                        //         border: 1px solid #dddddd;
                        //         text-align: left;
                        //         padding: 8px;
                        //     }
                
                        //     tr:nth-child(even) {
                        //         background-color: #dddddd;
                        //     }
                        // </style>
                        // <a href='http://localhost/practice/project/views/users/orders.php'> View Your Order</a>
                        // <div class='content container'>
                        //     <table>
                        //         <tr>
                        //             <td>Bill no.</td>
                        //             <td>4</td>
                        //         </tr>
                        //         <tr>
                        //             <td>Product name</td>
                        //             <td>Portronic</td>
                        //         </tr>
                        //         <tr>
                        //             <td>Quantity</td>
                        //             <td>1</td>
                        //         </tr>
                        //         <tr>
                        //             <td>Delivery Fees</td>
                        //             <td>333</td>
                        //         </tr>
                        //         <tr>
                        //             <td>Price</td>
                        //             <td>232</td>
                        //         </tr>
                        //         <tr>
                        //             <td>Discount</td>
                        //             <td>333</td>
                        //         </tr>
                        //     </table>
                        // </div>";
                        // $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);

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