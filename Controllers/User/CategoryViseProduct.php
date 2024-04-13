<?php
class CategoryViseProduct extends Connection
{
    private $status, $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function categoryViseProduct($category)
    {
        global $price;
        try {
            $productArr = [];
            $brandArr = [];

            $selectCategoryQuery = $this->connection->query("SELECT id from categories where name = '$category'");
            if ($selectCategoryQuery->num_rows) {
                $row = $selectCategoryQuery->fetch_array();
                $categoryId = $row['id'];

                $selectBrandQuery = $this->connection->query("SELECT name as brand_name from product_brands where category_id = $categoryId");
                if ($selectBrandQuery->num_rows) {
                    while ($row = $selectBrandQuery->fetch_assoc()) {
                        array_push($brandArr, $row);
                    }
                }

                $selectProductQuery = $this->connection->query("SELECT id, name, thumbnail, price, discount, brand, category_id from products where category_id = $categoryId");

                if ($selectProductQuery->num_rows) {
                    while ($row = $selectProductQuery->fetch_assoc()) {
                        array_push($productArr, $row);
                    }
    
                    $this->status = 200;
                    $this->message = "Fetch product successfully";
                } else {
                    throw new Exception("No product found!", 400);
                }
            } else {
                throw new Exception("No category found!", 400);
            }
            // if ($categoriesId == "") {
            //     $selectProductQuery = $this->connection->query("SELECT id, name, thumbnail, price, quantity, discount, brand, description, category_id from products");
            // } else {
            // }

        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("CategoryViseProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message,
                'products' => $productArr,
                'price' => $price,
                'brand' => $brandArr
            ];

            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>