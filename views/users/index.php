<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/index.css">
        <link rel="stylesheet" href="./../../public/assets/css/body.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
    ?>
    <section class="banner">
        <div class="banners">
            <img src="./../../public/assets/images/banner-4.png" alt="">
            <img src="./../../public/assets/images/banner-5.png" alt="">
            <img src="./../../public/assets/images/banner-6.png" alt="">
        </div>
    </section>

    <section class="">
        <div class="container pt-5">

            <div class="bestDealProduct" id="bestDealProduct">
                <div class="heading">
                    <h3>Best deal</h3>
                </div>
                <hr>
                <div class="dealProducts">
                    <div class="allProducts" id="allProducts">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5">
        <div class="smartphone" id="smartphone">
            <div class="heading">
                <h3>Smart phones</h3>
            </div>
            <hr>
            <div class="smartphoneProduct">
                <div class="allSmartphone" id="allSmartphone">
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5">
        <div class="laptop" id="laptop">
            <div class="heading">
                <h3>Laptops</h3>
            </div>
            <hr>
            <div class="laptopProduct">
                <div class="allLaptop" id="allLaptop">
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5">
        <div class="ac" id="ac">
            <div class="heading">
                <h3>AC</h3>
            </div>
            <hr>
            <div class="acProduct">
                <div class="allAC" id="allAC">
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"> </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/navbar.js"></script>
    <script src="./../../public/assets/js/index.js" type="module"></script>
</html>