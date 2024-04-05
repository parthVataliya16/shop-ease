<?php
class AddProduct extends Connection
{
    protected $status;
    protected $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function addProduct()
    {
        try {
            $dataArr = [
                'product name' => isset($_POST['name']) ? $_POST['name'] : NULL,
                'quantity' => isset($_POST['quantity']) ? $_POST['quantity'] : NULL,
                'price' => isset($_POST['price']) ? $_POST['price'] : NULL,
                'brand' => isset($_POST['brands']) ? $_POST['brands'] : NULL,
                'categories' => isset($_POST['categories']) ? $_POST['categories'] : NULL,
                'discount' => isset($_POST['discount']) ? $_POST['discount'] : NULL
            ];
    
            foreach ($dataArr as $key => $value) {
                if ($value == NULL) {
                    $flag = false;
                    throw new Exception($key . " is required", 400);
                }
            }
            $dataArr = sanitizeData($dataArr);
    
            $name = $dataArr['product name'];
            $quantity = $dataArr['quantity'];
            $price = $dataArr['price'];
            $category = $dataArr['categories'];
            $brand = $dataArr['brand'];
            $description = $_POST['description'];
            $discount = $dataArr['discount'];
            $imageName = time();
    
            if (!empty($_FILES["images"]["name"]) || !empty($_FILES['thumbnail']["name"])) {
                $numberOfImage =  count($_FILES["images"]['name']);
                $imageArr = [];
    
                if ($numberOfImage > 5) {
                    $this->status = 400;
                    $this->message = "Maximum number of images you have to upload is 5";
                } elseif ($numberOfImage < 1) {
                    $this->status = 400;
                    $this->message = "Minimum number of images you have to upload is 1";
                } else {
                    $targetDir = './../public/uploads/';
                    $imgType = ["png", "jpg", "jpeg"];
                    
                    foreach ($_FILES['images']['name'] as $img => $val) {
                        $imageFileType = strtolower(pathinfo($_FILES['images']['name'][$img],PATHINFO_EXTENSION));
                        $mimeType = mime_content_type($_FILES['images']['tmp_name'][$img]);
                        $allowMimetype = ['image/png', 'image/jpeg', 'image/jpg'];
            
                        if (! (in_array($mimeType, $allowMimetype) || in_array($imageFileType, $imgType))) {
                            throw new Exception("Invalid image type", 400);
                        }
                        array_push($imageArr, $imageName);
                        move_uploaded_file($_FILES['images']['tmp_name'][$img], $targetDir . $imageName);
                        $imageName++;
                    }
    
                    $selectCategoryID = $this->connection->query("SELECT id from categories 
                                        where name = '$category'");
    
                    $result = $selectCategoryID->fetch_assoc();
                    $categoryID = $result['id'];

                    $slectBrandID = $this->connection->query("SELECT id from product_brands where name = '$brand'");
                    $result = $slectBrandID->fetch_assoc();
                    $brandID = $result['id'];

                    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetDir . $imageName);
                    array_push($imageArr, $imageName);

                    $insertProduct = $this->connection->prepare("INSERT into products
                                    (name, price, quantity, discount, thumbnail, description, brand_id, category_id) 
                                    values (?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertProduct->bind_param("siiissii", $name, $price, $quantity, $discount, $imageName, $description, $brandID, $categoryID);
                    $insertProduct->execute();

                    $selectID = $this->connection->query( "SELECT id FROM products where name = '$name'");
                    $result = $selectID->fetch_assoc();
                    $id = $result['id'];
    
                    $insertImages = $this->connection->prepare("INSERT into product_images(product_id, name) 
                    values (?, ?)");

                    foreach ($imageArr as $img) {
                        $insertImages->bind_param("is", $id, $img);
                        $insertImages->execute();
                    }
    
                    $this->status = 201;
                    $this->message = "Product inserted successfully";
                }
            } else {
               throw new Exception("Please select an image file to upload.", 400);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            error("AddProduct.php", $error->getCode(), $error->getMessage(), $error->getLine());
        } finally {   
            $responseArr = array(
                'status' => $this->status,
                'message' => $this->message
            );
            return json_encode($responseArr);
        }
    }
}
