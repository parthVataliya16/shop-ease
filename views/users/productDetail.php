<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/body.css">
        <link rel="stylesheet" href="./../../public/assets/css/productDetail.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
    ?>
        <!-- <button class="backButton" onclick="history.go(-1);"><i class="fa-solid fa-arrow-left"></i></button> -->

        <div class="productDetail mt-3">
            <div class="row m-0">
                <div class="col-lg-5">
                    <div class="row m-0">
                        <div class="col-lg-3">
                            <div class="productImages d-flex flex-column">
                            </div>
                        </div>
                        <div class="col-lg-9 d-flex flex-column thumbnailAndButtons">
                            <div class="productThumbnail">
                                <img class="thumbnail img-fuild" alt="Thumbnail of product">
                            </div>
                            <div class="buttons d-flex">
                                <div class="addToCart">
                                    <button class="addToCartButton btn">
                                        Add to Cart
                                    </button>
                                </div>
                                <div class="buyNow">
                                    <button class="buyNowButton btn">
                                        Move to bag
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="productDetail">
                        <div class="productBrand">
                            <h1 class="brand">
                            </h1>
                        </div>
                        <div class="productName">
                            <h5 class="name"></h5>
                        </div>
                        <div class="productPrice">
                            <p class="m-0 fs-3">
                                <span class="discount text-success"></span>
                                <span class="offerPrice"></span>
                            </p>
                            <p class="m-0">
                                <span class="originalPrice text-decoration-line-through"></span>
                            </p>
                            <span>Inclusive of all taxes</span>
                        </div>
                        <div class="productDescription">
                            <p class="description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-4 container">
            <h3>Other products</h3>
            <hr>
            <div class="otherProdcuts">
                <div class="allProducts container-fluid mt-3" id="allProducts">
                </div>
            </div>
        </section>
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
    <script src="./../../public/assets/js/productDetail.js" type="module"></script>
</html>