<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="./../../public/assets/css/signup.css">
        <title>Document</title>
    </head>
    <body>
        <?php
        session_start();
        // require_once './../../middleware/checkRole.php';
        ?>
        <div class="wrapper">
            <div class="inner">
                <div class="logo">
                    <img src="./../../public/assets/images/logo.png" alt="">
                </div>
                <form id="registerForm">
                    <h3>Registration</h3>
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
                    <div class="form-wrapper">
                        <input type="password" placeholder="Password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-wrapper">
                        <input type="password" placeholder="Confirm Password" class="form-control" id="confirmPassword">
                    </div>
                    <span class="text-danger" id="passwordError"></span>
                    <div class="form-wrapper">
                        <span><a href="signin.php">Already have an account?</a></span>
                    </div>
                    <span class="text-danger" id="error"></span>
                    <button id="registerUser">Register</button>
                </form>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='./../../public/assets/js/signup.js'></script>
</html>