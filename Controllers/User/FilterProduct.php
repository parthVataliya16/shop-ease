<?php
class FilterProduct extends Connection {
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function filterProduct($priceArr) {
        try {
            $productArr = [];
            $filterArr = json_decode($priceArr);
            $priceArr = $filterArr[0];
            $lengthOfPriceArr = count($priceArr);
            
            // var_dump($lengthOfPriceArr);
            if ($lengthOfPriceArr && count($filterArr[1])) {
                $brandArr = substr(json_encode($filterArr[1]), 1, strlen(json_encode($filterArr[1])) - 2);
                $startPrice = explode("-", $priceArr[0])[0];
                $endPrice = explode("-", $priceArr[$lengthOfPriceArr - 1])[1];
                
                if (isset($_GET['category'])) {
                    $category = $_GET['category'];

                    $selectCategoryQuery = $this->connection->query("SELECT id from categories where name = '$category'");
                    $categoryID = $selectCategoryQuery->fetch_assoc();
                    $categoryID = $categoryID['id'];

                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where product.price >= $startPrice && product.price <= $endPrice && product.category_id = $categoryID && brand.name in ($brandArr)  order by id ");
                } else {
                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where product.price >= $startPrice && product.price <= $endPrice && && brand.name in ($brandArr) order by id ");

                }
                    if ($selectProductQuery->num_rows) {
                    while ($row = $selectProductQuery->fetch_assoc()) {
                        array_push($productArr, $row);
                    }
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            } else if ($lengthOfPriceArr && !count($filterArr[1])) {
                $startPrice = explode("-", $priceArr[0])[0];
                $endPrice = explode("-", $priceArr[$lengthOfPriceArr - 1])[1];

                if (isset($_GET['category'])) {
                    $category = $_GET['category'];

                    $selectCategoryQuery = $this->connection->query("SELECT id from categories where name = '$category'");
                    $categoryID = $selectCategoryQuery->fetch_assoc();
                    $categoryID = $categoryID['id'];

                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where product.price >= $startPrice && product.price <= $endPrice && product.category_id = $categoryID order by id ");
                } else {
                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where product.price >= $startPrice && product.price <= $endPrice order by id ");

                }
                    
                    if ($selectProductQuery->num_rows) {
                    while ($row = $selectProductQuery->fetch_assoc()) {
                        array_push($productArr, $row);
                    }
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            } elseif (count($filterArr[1]) && !$lengthOfPriceArr) {
                $brandArr = substr(json_encode($filterArr[1]), 1, strlen(json_encode($filterArr[1])) - 2);

                if (isset($_GET['category'])) {
                    $category = $_GET['category'];

                    $selectCategoryQuery = $this->connection->query("SELECT id from categories where name = '$category'");
                    $categoryID = $selectCategoryQuery->fetch_assoc();
                    $categoryID = $categoryID['id'];

                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where brand.name in ($brandArr) && product.category_id = $categoryID order by id ");
                } else {
                    $selectProductQuery = $this->connection->query("SELECT product.id, product.name, product.price, product.discount, brand.name as brand, product.thumbnail, product.category_id from products as product inner join product_brands as brand on product.brand_id = brand.id where brand.name in ($brandArr) order by id ");

                }
                    
                    if ($selectProductQuery->num_rows) {
                    while ($row = $selectProductQuery->fetch_assoc()) {
                        array_push($productArr, $row);
                    }
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            } else {
                $this->status = 400;
            }


        } catch (Exception $error) {
            error("FilterProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'products' => $productArr
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>