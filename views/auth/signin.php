<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/signin.css">
        <title>Document</title>
    </head>
    <body>
        <?php
        session_start();
        use Dotenv\Dotenv;

        require("./../../vendor/autoload.php");

        $dotenv = Dotenv::createImmutable("./../../");
        $dotenv->load();

        $googleCredentials = include('./../../config/google.php');
        include './../../services/googleService.php';

        $loginWithgoogle = new LoginWithGoogleService();

        require_once './../../middleware/checkRole.php';
        ?>
        <div class="d-flex justify-content-center" >
            <div class="wrapper loginForm">
                <div class="inner">
                    <div class="logo">
                        <img src="./../../public/assets/images/logo.png" alt="">
                    </div>
                    <form id="loginForm">
                        <h3>Sign In</h3>
                        <div class="form-wrapper">
                            <input type="text" placeholder="User name or email address" class="form-control" name="userName" id="userName">
                        </div>
                        <div class="form-wrapper">
                            <input type="password" placeholder="Password" class="form-control" name="password" id="password">
                        </div>
                        <span class="text-danger mt-2" id="error"></span>
                        <div class="form-wrapper">
                            <div class="btn">
                                <a href="<?php 
                                    echo $loginWithgoogle->createAuthUrl(); ?>"><img class = "google"src="./../../public/assets/images/google.png" alt="Google Logo"> Sign In with Google</a>
                            </div>
                        </div>
                        <div class="form-wrapper">
                            <span><a href="signup.php">Create an account?</a></span>
                        </div>
                        <button id="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./../../public/assets/js/signin.js" type="module"></script>
</html>