<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./../../public/assets/css/resetPassword.css">
        <title>Document</title>
    </head>
    <body>
        <div class="wrapper resetPasswordForm">
            <div class="inner">
                <form class="d-flex justify-content-center flex-column resetPasswordForm" id="resetPasswordForm">
                    <h3>Reset password</h3>
                    <div class="form-wrapper password mt-2">
                        <input type="password" class="passwordField" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-wrapper confirmPassword mt-2">
                        <input type="password" class="confirmPasswordField" id="confirmPassword" name="confirmPassword" placeholder="Enter confirmPassword">
                    </div>
                    <span class="text-danger" id="error"></span>
                    <span class="text-success" id="success"></span>
                    <div class="submit mt-2">
                        <input type="submit" class="btn btn-primary" id="resetPassword">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script src="./../../public/assets/js/resetPassword.js"></script>
</html>