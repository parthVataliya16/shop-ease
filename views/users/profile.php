<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/body.css">
        <link rel="stylesheet" href="./../../public/assets/css/sidebar.css">
        <link rel="stylesheet" href="./../../public/assets/css/profile.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
        require_once './layout/sidebar.php';
    ?>
    <div class="wrapper">
        <div class="inner">
            <form id="profile">
                <h3>Profile</h3>
                <div class="form-group">
                    <input type="text" placeholder="First Name" class="form-control" name="fname" id="fname">
                    <input type="text" placeholder="Last Name" class="form-control" name="lname" id="lname">
                </div>
                <div class="form-wrapper">
                    <input type="text" placeholder="Email Address" class="form-control" name="email" id="email">
                </div>
                <div class="form-wrapper row m-0">
                    <div class="col-6 p-0">    
                        <input type="text" placeholder="Phone number" class="form-control" name="phoneNumber" id="phoneNumber">
                    </div>
                    <div class="gender col-6">
                        <div class="row">
                            <div class="col-6">
                                <input type="radio" name="gender" id="male" value="male">
                                <label class="ms-2" for="male">Male</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="gender" id="female" value="female">
                                <label class="ms-2" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="passwordError"></span>
                <span class="text-danger" id="error"></span>
                <button id="updateUser">Update</button>
            </form>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/profile.js" type="module"></script>
    <script src="./../../public/assets/js/sidebar.js"></script>
</html>