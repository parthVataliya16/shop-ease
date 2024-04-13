<?php
class GetProduct extends Connection
{
    protected $status, $message;

    function __construct()
    {
        parent::__construct();
    }

    function getProduct($id = 0, $category = "")
    {
        try {
            $allProduct = [];
            if ($category == "") {
                if($id) {
                    $product = $this->connection->query("SELECT id, name, price, discount, brand, category_id from products where id = $id");
                    $productImage = $this->connection->query("SELECT name from product_images where product_id = $id");
    
                    if ($product->num_rows) {
                        $imageArr = [];
    
                        if ($productImage->num_rows) {
                            while ($row = $productImage->fetch_assoc()) {
                                array_push($imageArr, $row['name']);
                            }
                        }
                        while ($row = $product->fetch_assoc()) {
                            $row['images'] = $imageArr;
                            array_push($allProduct, $row);
                            $_SESSION['productId'] = $row['id'];
                        }
                        $this->status = 200;
                        $this->message = "Get product!";
                    } else {
                        $this->status = 400;
                        $this->message = "No product!";
                    }
                } else {
                    $product = $this->connection->query("SELECT id, name, price, quantity, discount, brand_id, description, category_id from products");
    
                    if ($product->num_rows == 0) {
                        throw new Exception("No product Found!", 400);
                    } else {
                        while ($row = $product->fetch_assoc()) {
                            $categoryId = $row['category_id'];
                            $selectCategoryQuery = $this->connection->query("SELECT name from categories where id = $categoryId");
                            $category = $selectCategoryQuery->fetch_assoc();
                            $category = $category['name'];
        
                            $brandId = $row['brand_id'];
                            $selectBrandQuery = $this->connection->query("SELECT name from product_brands where id = $brandId");
                            $brand = $selectBrandQuery->fetch_assoc();
                            $brand = $brand['name'];
        
        
                            $row['category'] = $category;
                            $row['brand'] = $brand;
                            unset($row['category_id']);
                            unset($row['brand_id']);
                            array_push($allProduct, $row);
                        }
                        $this->status = 200;
                        $this->message = "Get all products!";
                    }
                }
            } else {
                $selectCategoryQuery = $this->connection->query("SELECT id from categories where name = '$category'");
                $row = $selectCategoryQuery->fetch_assoc();
                $categoryId = $row['id'];

                $selectProductQuery = $this->connection->query("SELECT id, name, price, thumbnail,discount, category_id from products where category_id = $categoryId limit 8");

                if ($selectProductQuery->num_rows) {
                    while ($row = $selectProductQuery->fetch_assoc()) {
                        array_push($allProduct, $row);
                    }

                    $this->status = 200;
                    $this->message = "Get all product";
                } else {
                    $this->status = 400;
                    $this->message = "No product found!";
                }
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("GetProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $responseArr = array(
                'status' => $this->status,
                'message' => $this->message
            );
            $response = array();
            $response['response'] = $responseArr;
            $response['products'] = $allProduct;
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }
}
// $obj = new GetProduct();
// echo $obj->getProduct(24);
?>
