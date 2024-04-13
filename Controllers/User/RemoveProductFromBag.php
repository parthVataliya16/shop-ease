<?php
class RemoveProductFromBag extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function removeProductFromBag($productId)
    {
        try {
            $userName = $_SESSION['user'];
            $selectUserQuery = $this->connection->query("SELECT id from users where user_name = '$userName' || email_id = '$userName'");

            if ($selectUserQuery->num_rows) {
                $row = $selectUserQuery->fetch_assoc();
                $userId = $row['id'];
                $this->connection->query("DELETE from bags where product_id = $productId && user_id = $userId");

                $this->status = 200;
                $this->message = "Remove product from bag";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("RemoveProductFromBag.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $reposne = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header("content-type: application/json");
            return json_encode($reposne);
        }
    }
}

?>