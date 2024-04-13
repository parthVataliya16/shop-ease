<?php
class AddToBag extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function addToBag($productId)
    {
        try {
            if (! $productId) {
                throw new Exception("Product not found!", 400);
            }
            $userName = $_SESSION['user'];
            $userId = $this->connection->query("SELECT id from users where user_name = '$userName' || email_id = '$userName'");

            if ($userId->num_rows) {
                $row = $userId->fetch_assoc();
                $userId = $row['id'];

                $checkAlreadyExistsInCartQuery = $this->connection->query("SELECT id from bags where user_id = $userId && product_id = $productId");

                if ($checkAlreadyExistsInCartQuery->num_rows >= 1) {
                    throw new Exception("Product already exits in bag", 400);
                }
                $addToCart = $this->connection->prepare("INSERT into bags (user_id, product_id) values (?, ?)");
                $addToCart->bind_param("ii", $userId, $productId);
                $addToCart->execute();
                
                $this->status = 201;
                $this->message = "Product added to the bag";
            } else {
                throw new Exception("User not found!", 400);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("AddToBag.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];

            header('content-type: application/json');
            echo json_encode($response);
        }
    }
}

?>