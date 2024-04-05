<?php
class CategoricalProduct extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function categoricalProduct($id)
    {
        try {
            $productArr = [];
            $productId = $_SESSION['productId'];
            $selectProductQuery = $this->connection->query("SELECT id, name, price, discount, thumbnail from products where category_id = $id && id != $productId");

            if ($selectProductQuery->num_rows) {
                while ($row = $selectProductQuery->fetch_assoc()) {
                    array_push($productArr, $row);
                }
                $this->status = 200;
                $this->message = "Product fetch successfully!";
            } else {
                $this->status = 400;
                $this->message = "No product found!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("CategoricalProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message,
                'products' => $productArr
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>