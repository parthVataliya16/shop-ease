$(document).ready(function() {
    $.ajax({
        method: 'GET',
        url: '/Project/routes/web.php/v1/getCategory',
        success: function(result) {
            if (result.response.status == 200) {
                result.categories.forEach((value) => {
                    const product = document.createElement("option");
                    document.getElementsByClassName("categories")[0].appendChild(product);
                    product.classList.add("productCategory", "text-center");
                    product.setAttribute("id", `${value.id}`);
                    product.innerHTML = value.name;
                })
            } else {
                document.getElementsByClassName("categories")[0].innerHTML = result.response.message;
            }
        }
    })


    $("#categories").change(() => {
        const id = $("#categories").find(":selected").attr("id");
        getBrand(id);
    })

    const id = document.location.search.slice(4);
    $.ajax({
        method: 'GET',
        url: `/Project/routes/web.php/v1/getProductData/${id}`,
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                document.getElementById("name").setAttribute("value", `${result.products[0].name}`);
                document.getElementById("quantity").setAttribute("value", `${result.products[0].quantity}`);
                document.getElementById("price").setAttribute("value", `${result.products[0].price}`);
                document.getElementById("discount").setAttribute("value", `${result.products[0].discount}`);
                document.getElementById("productDescription").innerHTML = `${result.products[0].description}`;
                document.getElementById("quantity").innerHTML = result.products[0].quantity;
                
                const categories = document.querySelectorAll(".productCategory");
                categories.forEach((category) => {
                    const productCategory = category.getAttribute("id");
                    if (productCategory == result.products[0].category_id) {
                        category.setAttribute("selected", '');
                        getBrand($("#categories").find(":selected").attr("id"));
                    }
                })

                setTimeout(() => {
                    const brands = document.querySelectorAll(".productBrand");
                    brands.forEach(brand => {
                        const productBrand = brand.getAttribute("id");
                        if (productBrand == result.products[0].brand_id) {
                            brand.setAttribute("selected", "");
                        }
                    })
                }, 100);
            } else {
                document.getElementsByClassName("updateProductDataForm")[0].innerHTML = result.response.message;
            }
        }
    })
})


const id = document.location.search.slice(4);
const form = document.getElementById("productUpdateForm");
form.onsubmit = (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    $.ajax({
        method: 'POST',
        url: `/Project/routes/web.php/v1/updateProduct?id=${id}`,
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
            if (result.status == 200) {
                window.location.replace('dashboard.php');
            } else {
                if (result.message.toLowerCase().includes("duplicate")) {
                    notificationBox("Product is already added!");
                } else {
                    notificationBox(result.message);
                }
            }
        },
    })
}

const getBrand = (id) => {
    $.ajax({
        method: 'GET',
        url: `/Project/routes/web.php/v1/getProductBrand/${id}`,
        success: function(result) {
            if (result.status == 200) {
                document.getElementsByClassName("brands")[0].innerHTML = "";
                result.brands.forEach((value) => {
                    const product = document.createElement("option");
                    document.getElementsByClassName("brands")[0].appendChild(product);
                    product.classList.add("productBrand", "text-center");
                    product.setAttribute("id", value.id);
                    product.innerHTML = value.brand;
                })
            } else {
                document.getElementsByClassName("categories")[0].innerHTML = result.response.message;
            }
        }
    })
}

const notificationBox = (msg) => {
    Toastify({
        text: msg,
        close: true,
        stopOnFocus: true,
        style: {
            background: "#FF0000",
            color: "#ffffff"
          },
    }).showToast();
}