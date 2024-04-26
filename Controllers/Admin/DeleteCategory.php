<?php
class DeleteCategory extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteCategory($id)
    {
        try {
            $deleteProducts = $this->connection->query("DELETE from products where category_id = $id");
            if ($deleteProducts) {
                $deleteBrand = $this->connection->query("DELETE from product_brands where category_id = $id");
                if ($deleteBrand) {
                    $deleteCategory = $this->connection->query("DELETE from categories where id = $id");
                    if ($deleteCategory) {
                        $this->status = 200;
                    } else {
                        $this->status = 400;
                    }
                } else {
                    $this->status = 400;
                }
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            error("DeleteCategory.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
}

?>