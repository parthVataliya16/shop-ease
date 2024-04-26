<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/product.css">
        <link rel="stylesheet" href="./../../public/assets/css/body.css">
        <!-- <link rel="stylesheet" href="./../../public/assets/css/noProduct.css"> -->
        <title>Document</title>
    </head>
    <body > <!--style="background-color: #f0fff8;"-->
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
    ?>
    <div class="row m-0">
        <div class="col-lg-2 filter">
            <aside>
                <div class="productPriceFilter d-flex justify-content-center flex-column mt-4">
                    <div class="priceFilter-title">
                        <h4>Price</h4>
                    </div>
                    <div class="priceFilter">
                        <div class="price">
                            <input type="checkbox" class="priceCheckbox" name="price" id="10000-20000">
                            <label for="price" class="ms-2">&#8377;10000 to &#8377;20000</label>
                        </div>
                        <div class="price">
                            <input type="checkbox" class="priceCheckbox" name="price" id="20000-30000">
                            <label for="price" class="ms-2">&#8377;20000 to &#8377;30000</label>
                        </div>
                        <div class="price">
                            <input type="checkbox" class="priceCheckbox" name="price" id="30000-40000">
                            <label for="price" class="ms-2">&#8377;30000 to &#8377;40000</label>
                        </div>
                        <div class="price">
                            <input type="checkbox" class="priceCheckbox" name="price" id="40000-50000">
                            <label for="price" class="ms-2">&#8377;40000 to &#8377;50000</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="productBrandFilter d-flex justify-content-center flex-column mt-4">
                    <div class="brandFilter-title"><h4 class="brand-title"></h4></div>
                    <div class="brandFilter"></div>
                </div>
            </aside>
        </div>
            <?php
            // require_once './layout/noProductFound.php';
            ?>
            <div class="noProduct empty">
                <div class="noProductIcon">
                    <img src="./../../public/assets/images/noProduct.png" alt="">
                </div>
                <div class="noProductHeading">
                    <h3>No product found!</h3>
                </div>
                <div class="noProductInfo">
                    <p>Oops! These items are out of stock!</p>
                </div>
            </div>
        <div class="col-lg-10 products">
            <div class="allProducts container-fluid mt-3" id="allProducts">
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/navbar.js"></script>
    <script src="./../../public/assets/js/product.js" type="module"></script>
</html>