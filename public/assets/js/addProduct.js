window.onload = () => {
    $.ajax({
        method: 'GET',
        url: '/Project/routes/web.php/v1/getCategory',
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                result.categories.forEach((value) => {
                    const product = document.createElement("option");
                    document.getElementsByClassName("categories")[0].appendChild(product);
                    product.classList.add("product", "text-center");
                    product.setAttribute("id", value.id);
                    product.innerHTML = value.name;

                    
                })
            } else {
                document.getElementsByClassName("categories")[0].innerHTML = result.response.message;
            }
        }
    });

    getBrand(1);

    $("#categories").change(() => {
        const id = $("#categories").children(":selected").attr("id");
        getBrand(id);
    })

}

const form = document.getElementById("productForm");
form.onsubmit = (event) => {
    event.preventDefault();
    // console.log($("#categories").val());
    const formData = new FormData(form);
    $.ajax({
        method: 'POST',
        url: '/Project/routes/web.php/v1/addProduct',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
            console.log(result);
            let response = JSON.parse(result);
            if (response.status == 201) {
                // window.location.replace("dashboard.php");
            } else {
                if (response.message.toLowerCase().includes("duplicate")) {
                    notificationBox("Product is already added!");
                } else {
                    notificationBox(response.message);
                }
            }
        }
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
