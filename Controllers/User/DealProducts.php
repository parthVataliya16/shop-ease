<?php
class DealProducts extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function dealProducts()
    {
        try {
            $products = [];
            $selectDealProduct = $this->connection->query("SELECT id, name, thumbnail, price, discount from products order by discount DESC limit 8");
            while ($row = $selectDealProduct->fetch_assoc()) {
                array_push($products, $row);
            }
            $this->status = 200;
        } catch (Exception $error) {
            $this->status = $error->getCode();
            error("DealProducts.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $response = [
                'status' => $this->status,
                'products' => $products
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>