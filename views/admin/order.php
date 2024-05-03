<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../public/assets/css/sidebar.css">
        <link rel="stylesheet" href="./../../public/assets/css/adminOrder.css">
        <title>Document</title>
    </head>
    <body>
    <?php
        require_once './../../middleware/checkUserLogin.php';

        if (loginSuccessfully('admin')) {
            require_once './layout/navbar.php';
            require_once './layout/sidebar.php';
            require_once './layout/loader.php';
        ?>
            <section class="container-fluid ordertable hideLoader">
                <table class="table">
                    <thead>
                        <th>User's name</th>
                        <th>User's contact</th>
                        <th>Product's name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="orders">
                        
                    </tbody>
                    <div>
                        <span class="text-danger" id="error"></span>
                    </div>
                </table>
            </section>
            <div class="modal fade" id="updateOrderStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Order Status</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="status-name" class="col-form-label">Select Status:</label>
                                    <select name="orderStatus" id="orderStatus">
                                        <option value="canceled">Canceled</option>
                                        <option value="waiting">Waiting</option>
                                        <option value="accepted" selected>Accepted</option>
                                        <option value="delivered">Delivered</option>
                                    </select>
                                </div>
                                <div class="mb-3 deliveryDay">
                                    <label for="delivery-name" class="col-form-label">Delivery days:</label>
                                    <select name="deliveryDay" id="deliveryDay">
                                        <option value="nextDay">With In a Day</option>
                                        <option value="withInThree">With In 3 Days</option>
                                        <option value="withInFive">With In 5 Days</option>
                                        <option value="withInWeek">With In a Week</option>
                                        <option value="withInFifteen">With In 15 Days</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="updateOrdere">Update Status</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="viewOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                <table>
                                    <hr>
                                    <tr>
                                        <td>Product Name</td>
                                        <td id="productName"></td>
                                    </tr>
                                    <tr>
                                        <td>User Name</td>
                                        <td id="userName"></td>
                                    </tr>
                                    <tr>
                                        <td>User Contact Number</td>
                                        <td id="userContact"></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td id="quantity"></td>

                                    </tr>
                                    <tr>
                                        <td>Payment Type</td>
                                        <td id="paymentType"></td>

                                    </tr>
                                    <tr>
                                        <td>Payment Status</td>
                                        <td id="paymentStatus"></td>
                                    </tr>
                                </table>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/adminNavbar.js"></script>
    <script src="./../../public/assets/js/sidebar.js"></script>
    <script src="./../../public/assets/js/adminSideOrder.js"></script>
</html>