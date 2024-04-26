<?php    
class Category extends Connection
{
    protected $status, $message;

    function __construct() {
        parent::__construct();
    }

    function getCategory($id = 0)
    {
        try {
            $categoryArr = [];
            if ($id) {
                $getCategory = $this->connection->query("SELECT id, name FROM categories where id = $id");
                if ($getCategory->num_rows == 0) {
                    throw new Exception("Category not found!", 400);
                } else {
                    while ($row = $getCategory->fetch_assoc()) {
                        array_push($categoryArr, $row);
                    }
                    $this->status = 200;
                    $this->message = "Get the category";
                }
            } else {

                $getCategory = $this->connection->query("SELECT id, name FROM categories");
                if ($getCategory->num_rows == 0) {
                    throw new Exception("Category not found!", 400);
                } else {
                    while ($row = $getCategory->fetch_assoc()) {
                        $categoryID = $row['id'];
                        $selectNumberOfProductQuery = $this->connection->query("SELECT count(category_id) as number_of_product from products where category_id = $categoryID group by category_id");
                        if ($selectNumberOfProductQuery->num_rows) {
                            $numberOfProduct = $selectNumberOfProductQuery->fetch_assoc();
                            $row['numberOfProduct'] = $numberOfProduct['number_of_product'];
                        } else {
                            $row['numberOfProduct'] = 0;
                        }
                        array_push($categoryArr, $row);
                    }
                    $this->status = 200;
                    $this->message = "Get all the category";
                }
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("GetCategory.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            $responseArr = array(
                'status' => $this->status,
                'message' => $this->message
            );
            $response = array();
            $response['response'] = $responseArr;
            $response['categories'] = $categoryArr;
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }

    function updateCategory($id) 
    {
        try {
            $categoryName = $_POST['categoryName'];
            if ($id) {
                $updateCategory = $this->connection->query("UPDATE categories SET name = '$categoryName' where id = $id");
                if ($updateCategory) {
                    $this->status = 200;
                } else {
                    $this->status = 400;
                }
            }
        } catch (Exception $error) {
            error("Category.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
}
?>