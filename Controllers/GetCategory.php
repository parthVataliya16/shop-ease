<?php    
class GetCategory extends Connection
{
    protected $status, $message;

    function __construct() {
        parent::__construct();
    }

    function getCategory()
    {
        try {
            $categoryArr = [];
            $getCategory = $this->connection->query("SELECT id, name FROM categories");
            if ($getCategory->num_rows == 0) {
                throw new Exception("Category not found!", 400);
            } else {
                while ($row = $getCategory->fetch_assoc()) {
                    array_push($categoryArr, $row);
                }
                $this->status = 200;
                $this->message = "Get all the category";
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
}
?>