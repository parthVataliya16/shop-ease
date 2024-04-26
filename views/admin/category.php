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
    <link rel="stylesheet" href="./../../public/assets/css/categories.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully('admin')) {
        require_once './layout/navbar.php';
        require_once './layout/sidebar.php';
    ?>
        <div class="container-fluid">
            <button type="button" class="btn addNewCategory btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add New Category</button>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="category-name" class="col-form-label">Category:</label>
                                <input type="text" class="form-control" id="categoryName" placeholder="Enter category name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addNewCategory">Add Category</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="updateCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="category-name" class="col-form-label">Category:</label>
                                <input type="text" class="form-control" id="catName" placeholder="Enter category name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateCategoryName">Update Category</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid categoryTable">
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Number of products</th>
                    <th>Action</th>
                </thead>
                <tbody class="categories">

                </tbody>
                <div>
                    <span class="text-danger" id="error"></span>
                </div>
            </table>
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
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
<script src="./../../public/assets/js/adminNavbar.js"></script>
<script src="./../../public/assets/js/sidebar.js"></script>
<script src="./../../public/assets/js/categories.js" type="module"></script>

</html>