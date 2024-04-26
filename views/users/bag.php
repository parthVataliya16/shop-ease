<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/body.css">
        <link rel="stylesheet" href="./../../public/assets/css/bag.css">
        <link rel="stylesheet" href="./../../public/assets/css/productBill.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
    ?>
    <div class="emptyBag empty">
        <div class="emptyBagIcon">
            <img src="./../../public/assets/images/emptyBag.png" alt="Empty bag">
        </div>
        <div class="emptyBagHeading">
            <h3>Hey, it feels so light!</h3>
        </div>
        <div class="emptyBagInfo">
            <p>There is noting in your bag. Let's add some products</p>
        </div>
        <div class="addToCart">
            <a href="cart.php">
                <button>Add items from cart</button>
            </a>
        </div>
    </div>
    <div class="products">
        <div class="productIntoBag container mt-4">
            <div class="row">

                <div class=" d-flex flex-column col-lg-8">
                    <div class="productListing">

                    </div>
                    
                </div>
                <div class="bill col-lg-4">
                    <?php
                    require_once './layout/productBill.php';
                    ?>
                    <div class="row">
                        <a class="placeButton" href="address.php">
                            <button class="order btn btn-outline-success">Continue</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    } else {
        header("location: ./../auth/signin.php");
        exit;
    }
    ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/bag.js" type="module"></script>
    <script src="./../../public/assets/js/navbar.js"></script>
</html>