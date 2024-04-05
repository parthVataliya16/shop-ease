<?php
use Dotenv\Dotenv;

require_once './../vendor/autoload.php';
require_once './../Controllers/Connection.php';

require_once './../Controllers/Auth/Login.php';
require_once './../Controllers/Auth/Register.php';

require_once './../Controllers/Admin/AddProduct.php';
require_once './../Controllers/Admin/DeleteProduct.php';
require_once './../Controllers/Admin/UpdateProduct.php';

require_once './../Controllers/User/GetProductToUser.php';
require_once './../Controllers/User/ProductsIntocart.php';
require_once './../Controllers/User/AddToCart.php';
require_once './../Controllers/User/RemoveProductFromCart.php';
require_once './../Controllers/User/CategoryViseProduct.php';
require_once './../Controllers/User/AddToBag.php';
require_once './../Controllers/User/ProductIntoBag.php';
require_once './../Controllers/User/RemoveProductFromBag.php';
require_once './../Controllers/User/Address.php';
require_once './../Controllers/User/AddAddress.php';
require_once './../Controllers/User/UpdateAddress.php';
require_once './../Controllers/User/CategoricalProduct.php';
require_once './../Controllers/User/DealProducts.php';
require_once './../Controllers/User/PlaceOrder.php';
// require_once './../Controllers/User/GenderViseProduct.php';
require_once './../Controllers/GetCategory.php';
require_once './../Controllers/GetProduct.php';
require_once './../Controllers/Profile.php';
require_once './../Controllers/UpdateProfile.php';
require_once './../Controllers/ProductBrand.php';

require_once './../services/paymentService.php';

require_once './../middleware/sanitizeData.php';
require_once './../middleware/errorLog.php';
require_once './../productImages.php';

$dotenv = Dotenv::createImmutable('./../');
$dotenv->load();
$database = require_once('./../config/database.php');
$payment = require_once('./../config/payment.php');

$serverRequest = $_SERVER['REQUEST_METHOD'];
$endpoint = $_SERVER['PATH_INFO'];

preg_match("/^\/v1\/getProduct\/(\S+)$/", $endpoint, $matches);
// var_dump($matches);
$lengthOfMatchesArr = count($matches);
$category = "";
if ($lengthOfMatchesArr >= 2) {
    $category = $matches[1];
}

preg_match("/^\/v1\/addToCart\/(\d+)$|^\/v1\/removeProductFromCart\/(\d+)$|\/v1\/getProduct\/(\d+)$|\/v1\/addToBag\/(\d+)$|\/v1\/removeProductFromBag\/(\d+)$|\/v1\/address\/(\d+)$|\/v1\/updateAddress\/(\d+)$|^\/v1\/categoricalProduct\/(\d+)$|\/v1\/getProductBrand\/(\d+)$/", $endpoint, $matches);
$id = 0;
$lengthOfMatchesArr = count($matches);

if ($lengthOfMatchesArr >= 2) {
    $id = $matches[$lengthOfMatchesArr - 1];
}

switch ($serverRequest) {
    case 'POST':
        switch ($endpoint) {
            case '/v1/addProduct':
                $addProduct = new AddProduct();
                echo $addProduct->addProduct();
                break;
            case '/v1/updateProduct':
                $updateProduct = new UpdateProduct();
                echo $updateProduct->updateProduct($_GET['id']);
                break;
            case '/v1/login':
                $login = new Login();
                echo $login->login();
                break;
            case '/v1/register':
                $register = new Register();
                echo $register->register();
                break;
            case "/v1/addToCart/{$id}":
                $addToCart = new AddToCart();
                echo $addToCart->addToCart($id);
                break;
            case "/v1/addToBag/{$id}":
                $addToBag = new AddToBag();
                echo $addToBag->addToBag($id);
                break;
            case '/v1/addAddress':
                $addAddress = new AddAddress();
                echo $addAddress->addAddress();
                break;
            case "/v1/updateAddress/{$id}":
                $updateAddress = new UpdateAddress();
                echo $updateAddress->updateAddress($id);
                break;
            case "/v1/update":
                $updateProfile = new UpdateProfile();
                echo $updateProfile->UpdateProfile();
                break;
            case "/v1/placeOrder":
                $placeOrder = new PlaceOrder();
                echo $placeOrder->placeOrder();
                break;
        }
        break;
        // if ($endpoint == '/addProduct') {
        // } elseif ($endpoint == '/updateProduct') {
        // } elseif ($endpoint == '/login'){
        // } elseif ($endpoint == '/register') {
        // }
        // break;
    case 'GET':
        switch ($endpoint) {
            case '/v1/getCategory':
                $categories = new GetCategory();
                echo $categories->getCategory();
                break;
            case "/v1/getProduct":
                $getProductDetail = new GetProduct();
                echo $getProductDetail->getProduct();
                break;
            case "/v1/getProduct/{$id}":
                $getProductDetail = new GetProduct();
                echo $getProductDetail->getProduct($id);
                break;
            case "/v1/getProduct/{$category}":
                $getProductDetail = new GetProduct();
                echo $getProductDetail->getProduct(0, $category);
                break;
            case '/v1/getProductsToUser':
                if (isset($_GET['productName'])) {
                    $getProductsToUser = new GetProductsToUser();
                    echo $getProductsToUser->getProductsToUser($_GET['productName']);
                } else {
                    $getProductsToUser = new GetProductsToUser();
                    echo $getProductsToUser->getProductsToUser();
                }
                break;
            case '/v1/productIntoCart':
                $productsIntoCart = new ProductsIntoCart();
                echo $productsIntoCart->productsIntoCart();
                break;
            case '/v1/productCategoryVise':
                if (isset($_GET['categoryId'])) {
                    $categoryViseProduct = new CategoryViseProduct();
                    echo $categoryViseProduct->categoryViseProduct($_GET['categoryId']);
                }
                break;
            case '/v1/productIntoBag':
                $productIntoBag = new ProductIntoBag();
                echo $productIntoBag->productIntoBag();
                break;
            case '/v1/address':
                $addresses = new Address();
                echo $addresses->address();
                break;
            case "/v1/address/{$id}":
                $address = new Address();
                echo $address->address($id);
                break;
            case "/v1/categoricalProduct/{$id}":
                $categoricalProduct = new CategoricalProduct();
                echo $categoricalProduct->categoricalProduct($id);
                break;
            case "/v1/profile":
                $profile = new Profile();
                echo $profile->profile();
                break;
            case "/v1/getProductBrand/{$id}":
                $productBrand = new ProductBrand();
                echo $productBrand->productBrand($id);
                break;
            case "/v1/dealProducts":
                $dealProducts = new DealProducts();
                echo $dealProducts->dealProducts();
        }
        break;

        // if ($endpoint == '/getCategory') {
        // } elseif ($endpoint == '/getProduct') {
        // } elseif ($endpoint == '/getProductImages') {
        // } elseif ($endpoint == '/getProductsToUser') {
        // }
        // break;
    case 'DELETE':
        // echo "1";
        switch ($endpoint) {
            // echo "1";
            case '/v1/deleteProduct':
                $id = $_GET['id'];
                $deleteProduct = new DeleteProduct();
                echo $deleteProduct->deleteProduct($id);
                break;
            case "/v1/removeProductFromCart/{$id}":
                $removeProductFromCart = new RemoveProductFromCart();
                echo $removeProductFromCart->removeProductFromCart($id);
                break;
            case "/v1/removeProductFromBag/{$id}":
                $removeProductFromBag = new RemoveProductFromBag();
                echo $removeProductFromBag->removeProductFromBag($id);
        }
        break;

        // if ($endpoint == '/deleteProduct') {
        // }
        // break;
    case 'PUT':
        
    //    echo $_GET['id'];
    //    echo json_decode(file_get_contents('php://input'), true);
        // if ($endpoint == '/updateProduct') {
        //     $updateProduct = new UpdateProductData();
        //     echo $updateProduct->updateProductData($_GET['id']);
        // }
        break;
    default:
        echo 'HTTP request not found!';
}
?>