<?php
class ProductBrand extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function productBrand($id=0)
    {
        try {
            $brand = [];
            if ($id) {
                $selectBrandQuert = $this->connection->query("SELECT id, name as brand from product_brands where category_id = $id");
                
                if ($selectBrandQuert->num_rows) {
                    while ($row = $selectBrandQuert->fetch_assoc()) {
                        array_push($brand, $row);
                    }
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            } else {
                $selectBrandQuert = $this->connection->query("SELECT id, name as brand from product_brands");

                if ($selectBrandQuert->num_rows) {
                    while ($row = $selectBrandQuert->fetch_assoc()) {
                        $brandID = $row['id'];
                        $selectNumberOfProductQuery = $this->connection->query("SELECT count($brandID) as number_of_product from products where brand_id = $brandID group by brand_id");
                        if ($selectNumberOfProductQuery->num_rows) {
                            $numberOfProduct = $selectNumberOfProductQuery->fetch_assoc();
                            $row['numberOfProduct'] = $numberOfProduct['number_of_product'];
                            $this->status = 200;
                        } else {
                            $row['numberOfProduct'] = 0;
                        }
                        array_push($brand, $row);
                    }
                }
            }

        } catch (Exception $error) {
            $this->status = $error->getCode();
            error("ProductBrand.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'brands' => $brand
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }

    public function addBrand()
    {
        try {
            $brandName = $_POST['brandName'];
            $category = $_POST['category'];
            
            // Prepare and bind the category name for the query
            $selectCategoryIdQuery = $this->connection->prepare("SELECT id FROM categories WHERE name = ?");
            $selectCategoryIdQuery->bind_param("s", $category);
            $selectCategoryIdQuery->execute();
            $result = $selectCategoryIdQuery->get_result();
            
            if ($result->num_rows > 0) {
                $categoryRow = $result->fetch_assoc();
                $categoryID = $categoryRow['id'];
                
                // Prepare and bind parameters for the INSERT query
                $addBrandQuery = $this->connection->prepare("INSERT INTO product_brands (category_id, name) VALUES (?, ?)");
                $addBrandQuery->bind_param("is", $categoryID, $brandName);
                
                // Execute the INSERT query
                if ($addBrandQuery->execute()) {
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            } else {
                // Handle case where category doesn't exist
                $this->status = 400; // Or any appropriate error status
            }
        } catch (Exception $error) {
            error("ProductBrand.php", $error->getCode(), $error->getMessage(), $error->getLine());
            $this->status = 500; // Or any appropriate error status
        } finally {
            return $this->status;
        }
    }

    public function deleteBrand($id)
    {
        try {
            $deleteProductQuery = $this->connection->query("DELETE from products where brand_id = $id");
            if ($deleteProductQuery) {
                $deleteBrandQuery = $this->connection->query("DELETE from product_brands where id = $id");
                if ($deleteBrandQuery) {
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            }
        } catch (Exception $error) {
            error("ProductBrand.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }

    public function getBrand($id)
    {
        try {
            $brand = [];
            $selectBrandQeury = $this->connection->query("SELECT category.name as category , brand.name as brand from product_brands as brand inner join categories as category on category.id = brand.category_id where brand.id = $id");

            if ($selectBrandQeury->num_rows) {
                $row = $selectBrandQeury->fetch_assoc();
                array_push($brand, $row);
                $this->status = 200;
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            error("ProductBrand.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'brand' => $brand,
                'status' => $this->status
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }

    public function updateBrand($id)
    {
        try {
            $categoryName = $_POST['categoryName'];
            $brandName = $_POST['brandName'];
            $selectCategoryIdQuery = $this->connection->query("SELECT id from categories where name = '$categoryName'");
            if ($selectCategoryIdQuery->num_rows) {
                $row = $selectCategoryIdQuery->fetch_assoc();
                $categoryId = $row['id'];
                $updateBrandQuery = $this->connection->query("UPDATE product_brands set category_id = $categoryId, name = '$brandName' where id = $id");
                if ($updateBrandQuery) {
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            }
        } catch (Exception $error) {
            error("ProductBrand.php", $error->getCode(),$error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
    
}

?>