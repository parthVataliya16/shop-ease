<?php
class CategoryViseProduct extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function categoryViseProduct($categoriesId)
    {
        try {
            $productArr = [];

            if ($categoriesId == "") {
                $selectProductQuery = $this->connection->query("SELECT id, name, thumbnail, price, quantity, discount, brand, description, category_id from products");
            } else {
                $selectProductQuery = $this->connection->query("SELECT id, name, thumbnail, price, quantity, discount, brand, description, category_id from products where category_id in ($categoriesId)");
            }

            if ($selectProductQuery->num_rows) {
                while ($row = $selectProductQuery->fetch_assoc()) {
                    array_push($productArr, $row);
                }

                $this->status = 200;
                $this->message = "Fetch product successfully";
            } else {
                throw new Exception("No product found!", 400);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("CategoryViseProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
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