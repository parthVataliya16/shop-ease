<?php

use function GuzzleHttp\json_encode;

class Graph extends Connection 
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function orderGraph()
    {
        try {
            $product = [];
            $selectProductQuery = $this->connection->query("SELECT products.name, orders.product_id from orders inner join products on orders.product_id = products.id  where orders.status = 'accepted'");
            
            if ($selectProductQuery->num_rows) {
                while ($row = $selectProductQuery->fetch_assoc()) {
                    if ( ! in_array($row['name'], $product)) {
                        array_push($product, $row['name']);
                        $productID = $row['product_id'];
                        $selectQuantityQuery = $this->connection->query("SELECT quantity from orders where product_id = $productID");
    
                        $quantity = 0;
    
                        if ($selectQuantityQuery->num_rows) {
                            while ($row = $selectQuantityQuery->fetch_assoc()) {
                                $quantity += $row['quantity'];
                            }
                        }
                        array_push($product, $quantity);
                    }
                }
                $this->status = 200;
            } else {
                $this->status = 400;
            }

        } catch (Exception $error) {
            error("Graph.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'products' => $product
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }

    public function mostFavourite()
    {
        try {
            $product = [];
            $selectProductQuery = $this->connection->query("SELECT count(carts.product_id) as number_of_product, products.name
            FROM products 
            INNER JOIN carts ON carts.product_id = products.id 
            GROUP BY products.name 
            ORDER BY COUNT(carts.product_id) DESC 
            LIMIT 5");
            if ($selectProductQuery->num_rows) {
                while ($row = $selectProductQuery->fetch_assoc()) {
                    array_push($product, $row);
                }
                $this->status = 200;
            } else {
                $this->status = 400;
            }

        } catch (Exception $error) {
            error("Graph.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'product' => $product
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>