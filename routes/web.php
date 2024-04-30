<?php
use Dotenv\Dotenv;

require_once './../vendor/autoload.php';

require_once './../services/paymentService.php';
require_once './../services/mailService.php';

require_once './../Controllers/Connection.php';

require_once './../Controllers/Auth/Login.php';
require_once './../Controllers/Auth/Register.php';
require_once './../Controllers/Auth/ForgotPassword.php';
require_once './../Controllers/Auth/LinkExpire.php';
require_once './../Controllers/Auth/ResetPassword.php';

require_once './../Controllers/Admin/AddProduct.php';
require_once './../Controllers/Admin/DeleteProduct.php';
require_once './../Controllers/Admin/UpdateProduct.php';
require_once './../Controllers/Admin/AllOrders.php';
require_once './../Controllers/Admin/AddNewCategory.php';
require_once './../Controllers/Admin/DeleteCategory.php';

require_once './../Controllers/User/GetProductToUser.php';
require_once './../Controllers/User/Products.php';
require_once './../Controllers/User/AddToCart.php';
require_once './../Controllers/User/RemoveProductFromCart.php';
require_once './../Controllers/User/CategoryViseProduct.php';
require_once './../Controllers/User/AddToBag.php';
// require_once './../Controllers/User/ProductIntoBag.php';
require_once './../Controllers/User/RemoveProductFromBag.php';
require_once './../Controllers/User/Address.php';
require_once './../Controllers/User/AddAddress.php';
require_once './../Controllers/User/UpdateAddress.php';
require_once './../Controllers/User/CategoricalProduct.php';
require_once './../Controllers/User/DealProducts.php';
require_once './../Controllers/User/PlaceOrder.php';
require_once './../Controllers/User/PaymentSuccess.php';
require_once './../Controllers/User/OrderSuccessfull.php';
require_once './../Controllers/User/FilterProduct.php';
require_once './../Controllers/User/sendOTP.php';
require_once './../Controllers/User/ConfirmOTP.php';
require_once './../Controllers/User/CancelOrder.php';
// require_once './../Controllers/User/GenderViseProduct.php';
require_once './../Controllers/Category.php';
require_once './../Controllers/GetProduct.php';
require_once './../Controllers/Profile.php';
require_once './../Controllers/UpdateProfile.php';
require_once './../Controllers/ProductBrand.php';


require_once './../middleware/sanitizeData.php';
require_once './../middleware/errorLog.php';

$dotenv = Dotenv::createImmutable('./../');
$dotenv->load();
$database = require_once('./../config/database.php');
$payment = require_once('./../config/payment.php');
$mail = require_once('./../config/mail.php');

$serverRequest = $_SERVER['REQUEST_METHOD'];
$endpoint = $_SERVER['PATH_INFO'];

preg_match("/^\/v1\/getProduct\/(\S+)$|^\/v1\/productCategoryVise\/(\S+)$/", $endpoint, $matches);
// var_dump($matches);
$lengthOfMatchesArr = count($matches);
$category = "";
if ($lengthOfMatchesArr >= 2) {
    $category = $matches[$lengthOfMatchesArr - 1];
    $categoryName = strtolower($category);
    $price = require_once "./../config/$categoryName.php";
}

preg_match("/^\/v1\/addToCart\/(\d+)$|^\/v1\/removeProductFromCart\/(\d+)$|^\/v1\/getProduct\/(\d+)$|^\/v1\/addToBag\/(\d+)$|^\/v1\/removeProductFromBag\/(\d+)$|^\/v1\/address\/(\d+)$|^\/v1\/updateAddress\/(\d+)$|^\/v1\/categoricalProduct\/(\d+)$|^\/v1\/getProductBrand\/(\d+)$|^\/v1\/deleteCategory\/(\d+)$|^\/v1\/getCategory\/(\d+)$|^\/v1\/updateCategory\/(\d+)$|^\/v1\/deleteBrand\/(\d+)$|^\/v1\/getBrand\/(\d+)$|^\/v1\/updateBrand\/(\d+)$|^\/v1\/cancelOrder\/(\d+)$/", $endpoint, $matches);
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
            case "/v1/paymentSuccess":
                $paymentSuccess = new PaymentSuccess();
                $paymentSuccess->paymentSuccess();
                break;
            case "/v1/orderSuccessfull":
                $orderSuccessfull = new OrderSuccessfull();
                echo $orderSuccessfull->orderSuccessfull();
                break;
            case "/v1/addNewCategory":
                $addNewCategory = new AddNewCategory();
                echo $addNewCategory->addNewCategory();
                break;
            case "/v1/updateCategory/{$id}":
                $updateCategory = new Category();
                echo $updateCategory->updateCategory($id);
                break;
            case "/v1/addBrand":
                $addBrand = new ProductBrand();
                echo $addBrand->addBrand();
                break;
            case "/v1/updateBrand/{$id}":
                $updateBrand = new ProductBrand();
                echo $updateBrand->updateBrand($id);
                break;
            case "/v1/sendOTP":
                $sendOTP = new SendOTP();
                echo $sendOTP->sendOTP();
                break;
            case "/v1/confirmOTP":
                $confirmOTP = new ConfirmOTP();
                echo $confirmOTP->confirmOTP();
                break;
            case "/v1/forgotPassword":
                echo "1";
                $forgotPassword = new ForgotPassword();
                echo $forgotPassword->forgotPassword();
                break;
            case '/v1/resetPassword':
                $resetPassword = new ResetPassword();
                echo $resetPassword->resetPassword($_GET['token']);
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
                $categories = new Category();
                echo $categories->getCategory();
                break;
            case "/v1/getCategory/{$id}":
                $categories = new Category();
                echo $categories->getCategory($id);
                break;
            case "/v1/getProduct":
                $getProductDetail = new GetProduct();
                if (isset($_GET['id'])) {
                    echo $getProductDetail->getProduct($_GET['id']);
                } else {    
                    echo $getProductDetail->getProduct();
                }
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
            case '/v1/productInto-Cart':
                $products = new Products();
                echo $products->products('carts');
                break;
            case "/v1/productCategoryVise/{$category}":
                $categoryViseProduct = new CategoryViseProduct();
                echo $categoryViseProduct->categoryViseProduct($category);
                break;
            case '/v1/productInto-Bag':
                $products = new Products();
                echo $products->products('bags');
                break;
            case '/v1/productInto-Order':
                $products = new Products();
                echo $products->products('orders');
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
            case "/v1/getBrand":
                $productBrand = new ProductBrand();
                echo $productBrand->productBrand();
                break;
            case "/v1/getProductBrand/{$id}":
                $productBrand = new ProductBrand();
                echo $productBrand->productBrand($id);
                break;
            case "/v1/getBrand/{$id}":
                $getBrand = new ProductBrand();
                echo $getBrand->getBrand($id);
                break;
            case "/v1/dealProducts":
                $dealProducts = new DealProducts();
                echo $dealProducts->dealProducts();
                break;
            case "/v1/allOrders":
                $allOrders = new AllOrders();
                echo $allOrders->allOrders();
                break;
            case "/v1/filterProduct":
                if (isset($_GET['price'])) {
                    $filterProduct = new FilterProduct();
                    echo $filterProduct->filterProduct($_GET['price']);
                }
                break;
            case "/v1/noOfProductInCart":
                $noOfProductInCart = new Products();
                echo $noOfProductInCart->noOfProductIn('carts');
                break;
            case "/v1/noOfProductInBag":
                $noOfProductInCart = new Products();
                echo $noOfProductInCart->noOfProductIn('bags');
                break;
            case '/v1/linkExpire' :
                $linkExpire = new LinkExpire();
                echo $linkExpire->linkExpire($_GET['token']);
                break;
            
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
                break;
            case "/v1/deleteCategory/{$id}":
                $deleteCategory = new DeleteCategory();
                echo $deleteCategory->deleteCategory($id);
                break;
            case "/v1/deleteBrand/{$id}":
                $deleteBrand = new ProductBrand();
                echo $deleteBrand->deleteBrand($id);
                break;
            case "/v1/cancelOrder/{$id}":
                $cancelOrder = new CancelOrder();
                echo $cancelOrder->cancelOrder($id);
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