window.onload = () => {
    $.ajax({
        method: 'GET',
        url: '/practice/Project/routes/web.php/v1/getCategory',
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

    getBrand(1);

    $("#categories").change(() => {
        const id = $("#categories").children(":selected").attr("id");
        getBrand(id);
    })

    const id = document.location.search.slice(4);
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/getProduct/${id}`,
        success: function(result) {
            if (result.response.status == 200) {
                document.getElementById("name").setAttribute("value", `${result.products[0].name}`);
                document.getElementById("quantity").setAttribute("value", `${result.products[0].quantity}`);
                document.getElementById("price").setAttribute("value", `${result.products[0].price}`);
                document.getElementById("discount").setAttribute("value", `${result.products[0].discount}`);
                document.getElementById("productDescription").innerHTML = `${result.products[0].description}`;
                
                const categories = document.querySelectorAll(".productCategory");
                categories.forEach((category) => {
                    const productCategory = category.getAttribute("id");
                    if (productCategory == result.products[0].category_id) {
                        category.setAttribute("selected", '');
                    }
                })

                const brands = document.querySelectorAll(".productBrand");
                brands.forEach(brand => {
                    const productBrand = brand.getAttribute("id");
                    if (productBrand == result.products[0].brand_id) {
                        brand.setAttribute("selected", "");
                    }
                })
            } else {
                document.getElementsByClassName("updateProductDataForm")[0].innerHTML = result.response.message;
            }
        }
    })

    // $.ajax({
    //     method: 'GET',
    //     url: `/practice/Project/admin/routes/web.php/v1/getProductImages?id=${id}`,
    //     success: function(result) {
    //         console.log(result);

    //         if (result.response.status == 200) {
    //             result.images.forEach((image, index) => {
    //                 if (index % 3 == 0) {
    //                     const row = document.createElement("div");
    //                     document.getElementsByClassName("productImages")[0].appendChild(row);
    //                     row.classList.add("row", "productImage");
    //                 }
    //                 const numberOfProductImageClass = document.getElementsByClassName("productImage").length;
    //                 const col = document.createElement("div");
    //                 document.getElementsByClassName("productImage")[numberOfProductImageClass - 1].appendChild(col);
    //                 col.classList.add("col-lg-4", "image")

    //                 const numberOfImageClass = document.getElementsByClassName("image").length;
    //                 const img = document.createElement("img");
    //                 document.getElementsByClassName("image")[numberOfImageClass - 1].appendChild(img);
    //                 img.classList.add("img-fluid");
    //                 img.setAttribute("src", `data:image/jpg;charset=utf8;base64,${image}`);
                    
    //             })
    //         }
    //     },
    //     error: function(result) {
    //         console.log(result);
    //     }
    // })
} 

const id = document.location.search.slice(4);
const form = document.getElementById("productUpdateForm");
form.onsubmit = (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    $.ajax({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/updateProduct?id=${id}`,
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
        url: `/practice/Project/routes/web.php/v1/getProductBrand/${id}`,
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