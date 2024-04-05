<?php
class ProductBrand extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function productBrand($id)
    {
        try {
            $brand = [];
            $selectBrandQuert = $this->connection->query("SELECT id, name as brand from product_brands where category_id = $id");

            if ($selectBrandQuert->num_rows) {
                while ($row = $selectBrandQuert->fetch_assoc()) {
                    array_push($brand, $row);
                }
                $this->status = 200;
            } else {
                $this->status = 400;
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
}

?>