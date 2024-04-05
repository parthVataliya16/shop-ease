<?php
class DeleteProduct extends Connection 
{
    protected $status, $message;
    
    function __construct() {
        parent::__construct();
    }
    function deleteProduct($id) 
    {
        try {
            $images = $this->connection->query("select name from product_images where product_id = $id");

            if ($images->num_rows == 0) {
                throw new Exception("Product not found!", 400);
            } else {
                while($row = $images->fetch_assoc()) {
                    $imageName = $row['name'];
                    if (file_exists('./../public/uploads/' . $imageName)) {
                        unlink('./../public/uploads/' . $imageName);
                    }
                }
                $this->connection->query("DELETE from bags where product_id = $id");
                $this->connection->query("DELETE from carts where product_id = $id");
                $this->connection->query("DELETE from product_images where product_id = $id");
                $this->connection->query("DELETE from products where id = $id");
                $this->status = 200;
                $this->message = "Product deleted successfully!";
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("DeleteProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>