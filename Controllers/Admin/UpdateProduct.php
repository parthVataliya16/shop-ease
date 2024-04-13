<?php
class UpdateProduct extends Connection
{
    protected $status, $message;
    function __construct()
    {
        parent::__construct();
    }

    function updateProduct($id)
    {
        try {
            $productData = $this->connection->query("SELECT name from products 
            where id = $id");
            
            if ($productData->num_rows == 0) {
                throw new Exception("Product not found!", 400);
            } else {
                $name = $_POST['name'];
                $quantity = $_POST['quantity'];    
                $price = $_POST['price'];
                $category = $_POST['categories'];
                $brand = $_POST['brands'];
                $discount = $_POST['discount'];
                $description = $_POST['description'];

                $categoryID = $this->connection->query("SELECT id from categories 
                where name = '$category'");
                $result = $categoryID->fetch_assoc();
                $categoryID = $result['id'];

                $brandId = $this->connection->query("SELECT id from product_brands 
                where name = '$brand'");
                $result = $brandId->fetch_assoc();
                $brandId = $result['id'];

                $updatedProductData = $this->connection->prepare("UPDATE products set name = ?, quantity = ?, price = ?, discount = ?, description = ?, category_id = ?, brand_id = ? where id = ?");
                $updatedProductData->bind_param("siiisiii", $name, $quantity, $price, $discount, $description, $categoryID, $brandId, $id);

                if ($updatedProductData->execute()) {
                    $this->status = 200;
                    $this->message = "Product updated successfully!";
                } else {
                    throw new Exception("Product is not updated!", 304);
                }
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("UpdateProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $responseArr = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header("Content-type: application/json");
            return json_encode($responseArr);
        }
    }
}

?>