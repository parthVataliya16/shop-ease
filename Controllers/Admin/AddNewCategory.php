<?php
class AddNewCategory extends Connection
{
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function addNewCategory()
    {
        try {
            $categoryName = $_POST['categoryName'];
            $addNewCategoryQuery = $this->connection->prepare("INSERT into categories (name) value (?)");
            $addNewCategoryQuery->bind_param("s", $categoryName);
            if ($addNewCategoryQuery->execute()) {
                $this->status = 200;
            } else {
                $this->status = 400;
            }
        } catch (Exception $error) {
            error("AddNewCategory.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {
            return $this->status;
        }
    }
}

?>