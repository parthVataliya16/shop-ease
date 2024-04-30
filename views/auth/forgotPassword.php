<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/forgotPassword.css">
        <title>Document</title>
    </head>
    <body>
        <div class="wrapper forgotPasswordForm" id="form">
            <div class="mailSend">
                <p id="text"></p>
            </div>
            <div class="inner" id="forgotPasswordForm">
                <form class="d-flex justify-content-center flex-column forgotPasswordForm" id="forgotPasswordForm">
                    <h3>Forgot password</h3>
                    <div class="form-wrapper email mt-2">
                        <input type="email" name="email" class="emailField" id="email"  placeholder="Enter email">
                    </div>
                    <div class="form-wrapper forgotPassword mt-2">
                        <p><a href="signin.php">Sign In</a></p>
                    </div>
                    <span class="text-danger" id="error"></span>
                    <span class="text-success" id="success"></span>
                    <div class="submit mt-2">
                        <input type="submit" class="btn btn-primary" id="sendMail">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="./../../public/assets/js/forgotPassword.js"></script>
</html>