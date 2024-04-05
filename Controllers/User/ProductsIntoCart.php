<?php
class ProductsIntoCart extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function productsIntoCart()
    {
        try {
            $productsArr = [];
            $userName = $_SESSION['user'];
            $selectUserIdQuery = $this->connection->query("SELECT id from users where user_name = '$userName' || email_id = '$userName'");

            if ($selectUserIdQuery->num_rows) {
                $row = $selectUserIdQuery->fetch_assoc();
                $suerId = $row['id'];
                $productIdIntoCartQuery = $this->connection->query("SELECT product_id from carts where user_id = $suerId");

                if ($productIdIntoCartQuery->num_rows) {
                    while ($row = $productIdIntoCartQuery->fetch_assoc()) {
                        $productId = $row['product_id'];
                        $selectProductQuery = $this->connection->query("SELECT id, name, thumbnail, price, quantity, brand, discount from products where id = $productId");
                        while ($row = $selectProductQuery->fetch_assoc()) {
                            array_push($productsArr, $row);
                        }
                    }
                    $this->status = 200;
                    $this->message = "Fetch all products into the cart";
                } else {
                    throw new Exception("No product found!", 400);
                }
            } else {
                throw new Exception("Invalid user!", 400);
            }
            
            
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("ProductIntoCart.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message,
                'products' => $productsArr
            ];
            header("Content-type: application/json");
            return json_encode($response);
        }
    }
}
