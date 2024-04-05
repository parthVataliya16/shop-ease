<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/addProduct.css">
        <title>Document</title>
    </head>
    
    <body>
    <?php
    require_once './../../middleware/checkUserLogin.php';

    if (loginSuccessfully('admin')) {
    ?>
        <button class="backButton" onclick="history.go(-1);"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="wrapper">
            <div class="inner">
                <form id="productForm">
                    <h3>Add product</h3>
                    <div class="form-wrapper">
                        <div class="productName d-flex flex-column">
                            <label class="form-label" for="name">Enter product name</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="priceAndDiscount d-flex row flex-row">
                            <div class="price d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label for="price">Enter price</label>
                                <input class="form-control" class="priceInput"  type="number" class="price" name="price" id="price">
                            </div>
                            <div class="discount d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label for="discount">Enter discount (in %)</label>
                                <input class="form-control" class="discountInput"  type="number" class="discount" name="discount" id="discount" >
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper mb-2">
                        <div class="categoryAndBrand d-flex row flex-row">
                            <div class="category  d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label class="mb-2" for="category">Select category: </label>
                                <select name="categories" class="categories p-2" id="categories"></select>
                            </div>
                            <div class="brand d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label class="mb-2" for="category">Select Brand: </label>
                                <select name="brands" class="brands p-2" id="brands"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="quantity d-flex  flex-row">
                            <div class="quantity d-flex align-items-center">
                                <label class="w-100" for="quantity">Enter quantity:</label>
                                <input class="form-control" class="quantityInput"  type="number" class="quantity" name="quantity" id="quantity" >
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="description">
                            <label for="description">Enter description: </label>
                            <textarea class="form-control" name="description" id="productDescription" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="iamges mb-3">
                            <p class="mb-2">Thumbnail:</p>
                            <input type="file" name="thumbnail" id="images" accept="image/x-png, image/jpeg, image/jpg">
                            <p>(Only .png, .jpeg, .jpg file accepted)</p>
                        </div>
                        <div class="iamges">
                            <p class="mb-2">Other images:</p>
                            <input type="file" name="images[]" id="images" multiple accept="image/x-png, image/jpeg, image/jpg">
                            <p>(Only .png, .jpeg, .jpg file accepted)</p>
                        </div>
                    </div>
                    <span class="text-danger" id="error"></span>
                    <div class="submitButton">
                        <button class="btn submit" id="submitData">Submit</button>
                    </div>
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
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../public/assets/js/addProduct.js"></script>
</html>