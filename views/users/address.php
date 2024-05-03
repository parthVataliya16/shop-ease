<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
    <link rel="stylesheet" href="./../../public/assets/css/body.css">
    <link rel="stylesheet" href="./../../public/assets/css/productBill.css">
    <link rel="stylesheet" href="./../../public/assets/css/address.css">
    <!-- <link rel="stylesheet" href="./../../public/assets/css/loader.css"> -->
    <title>Document</title>
</head>

<body>
    <?php
    // use Dotenv\Dotenv;
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully()) {
        require_once './layout/navbar.php';
        require_once './layout/loader-1.php';
    ?>
        <div class="userAddresses">
            <div class="address container mt-4">
                <div class="row">
                    <div class="addresses d-flex flex-column col-lg-8">
                        <div class="paymentOptions container mb-3">
                            <h5 class="mb-3">Select payment option </h5>
                            <div class="codOption mb-2">
                                <input type="radio" name="payment" id="payment" value="cod">
                                <label for="cod">Cash on delivery</label>
                            </div>
                            <div class="onlineOption mb-2">
                                <input type="radio" name="payment" id="payment" value="online">
                                <label for="online">UPI/ Debit card/ Credit card</label>
                            </div>
                        </div>
                        <div class="allAddresses">
                            <h5 class="mb-3">Select delivery address</h5>
                        </div>
                        <div class="addNewAddress">
                            <a type="button" class="addAddress" data-bs-toggle="modal" data-bs-target="#model">+ Add new address</a>
                        </div>
                        <div class="modal fade" id="editAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new Address</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addNewAddressForm" method="post">
                                            <div class="mb-3 d-flex flex-column address">
                                                <label for="Address-name" class="col-form-label">Address</label>
                                                <input type="text" name="street" id="street" placeholder="Address (House No., Building, Street, Area)*">
                                                <input type="text" name="pincode" id="pincode" placeholder="Pin code*">
                                                <input type="text" name="town" id="town" placeholder="Town*">
                                                <div class="row m-0">
                                                    <div class="col-lg-6">
                                                        <input type="text" name="city" id="city" placeholder="City*">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="state" id="state" placeholder="State*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="updateAddress">update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new Address</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addNewAddressForm" method="post">
                                            <div class="mb-3 d-flex flex-column address">
                                                <label for="Address-name" class="col-form-label">Address</label>
                                                <input type="text" name="street" id="newStreet" placeholder="Address (House No., Building, Street, Area)*">
                                                <input type="text" name="pincode" id="newPincode" placeholder="Pin code*">
                                                <input type="text" name="town" id="newTown" placeholder="Town*">
                                                <div class="row m-0">
                                                    <div class="col-lg-6">
                                                        <input type="text" name="city" id="newCity" placeholder="City*">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="state" id="newState" placeholder="State*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="newAddress">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-lg-4">
                        <div class="bill">

                        <?php
                        require_once './layout/productBill.php';
                        ?>
                        <div class="placeOrder">
                            <!-- <a href="payment.php"> -->
                            <!-- <button class="countinue">Place order</button> -->
                            <!-- <form class="countinue" action="./../../routes/web.php/v1/paymentSuccess" id="placeOrder" method="POST">
                                <input type="hidden" custom="Hidden Element" name="hidden">
                                <input type="submit" name="place order" id="placeOrderButton" value="place order">
                            </form> -->
                            <?php require_once './layout/loader.php'?>
                            <a class="submitPlaceOrder" >
                                <button class="placeOrderButton btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#otpForm" id="sendOTP">Place Order</button>
                            </a>
                            <!-- </a> -->
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="otpForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">OTP Send To Your Mail Address</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-1">
                                <label for="otp-name" class="col-form-label">OTP:</label>
                                <input name="otp" id="otp" placeholder="Enter OTP" maxlength="6"></input>
                            </div>
                            <div class="error text-danger">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmOTP">Confirm</button>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
<script src="./../../public/assets/js/navbar.js" type="module"></script>
<script src="./../../public/assets/js/address.js" type="module"></script>

</html>