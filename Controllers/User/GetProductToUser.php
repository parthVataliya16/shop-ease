<?php
class GetProductsToUser extends Connection
{
    protected $status, $message;

    function __construct()
    {
        parent::__construct();
    }

    function getProductsToUser($productName = null)
    {
        try {
            $productDetailArr = [];
            if ($productName == null) {
                $productDetail = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id order by id");
            } else {
                $productDetail = $this->connection->query("SELECT id, name, price, discount, thumbnail from products where name like '%$productName%'");
            }

            if ($productDetail->num_rows == 0) {
                throw new Exception("Product not found!", 400);
            } else {
                while ($row = $productDetail->fetch_assoc() ) {
                    // $row['thumbnail'] = base64_encode($row['thumbnail']);
                    array_push($productDetailArr, $row);
                }
                $this->status = 200;
                $this->message = "All product get successfully";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("GetProductToUser.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $responseArr = [
                'status' => $this->status,
                'message' => $this->message
            ];
            
            $response = [
                'response' => $responseArr,
                'products' => $productDetailArr
            ];
            header('content-type: application/json');
            return json_encode($response);
        }
    }
}
?>