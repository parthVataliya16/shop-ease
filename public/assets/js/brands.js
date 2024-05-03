import { tostifyBox } from "./functions.js";

window.onload = () => {
    $.ajax ({
        method: "GET",
        url: `/Project/routes/web.php/v1/getBrand`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                $(".loader").addClass("hideLoader");
                $(".categoryTable").removeClass("hideLoader");
                $(".sidebar").removeClass("hideLoader");

                result.brands.forEach((brand, index) => {
                    const tableRow = document.createElement("tr");
                    document.getElementsByClassName("categories")[0].appendChild(tableRow);
                    tableRow.classList.add("tableRow");

                    const numberOfRow = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(numberOfRow);
                    numberOfRow.innerHTML = index + 1;

                    const name = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(name);
                    name.innerHTML = brand.brand;

                    const numberOfProduct = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(numberOfProduct);
                    numberOfProduct.innerHTML = brand.numberOfProduct;

                    const action = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(action);
                    action.classList.add("action");

                    const numberOfActionOnproductDataClass = document.getElementsByClassName("action").length;
                    const actionButton = document.createElement("button");
                    document.getElementsByClassName("action")[numberOfActionOnproductDataClass - 1].appendChild(actionButton);
                    actionButton.classList.add("actionButton");
                    actionButton.innerHTML = "Action"

                    const dropdownButtons = document.createElement("div");
                    document.getElementsByClassName("action")[numberOfActionOnproductDataClass - 1].appendChild(dropdownButtons);
                    dropdownButtons.classList.add("dropdownButtons");

                    const numberOfDropdownButtons = document.getElementsByClassName("dropdownButtons").length;
                    const deleteButton = document.createElement("button");
                    document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(deleteButton);
                    deleteButton.classList.add("btn", "btn-danger", "deleteButton");
                    deleteButton.setAttribute("id", `btn_${brand.id}`)
                    deleteButton.innerHTML = "Delete"
                    
                    const updateButton = document.createElement("button");
                    document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(updateButton);
                    updateButton.classList.add("btn", "btn-primary", "updateButton");
                    updateButton.setAttribute("data-bs-toggle", "modal");
                    updateButton.setAttribute("data-bs-target", "#updatebrand");
                    updateButton.setAttribute("id", `update_${brand.id}`);
                    updateButton.innerHTML = "Update";
                });

                const updateButton = document.querySelectorAll(".updateButton");
                updateButton.forEach(button => {
                    button.addEventListener("click", () => {
                        const id = button.getAttribute("id").slice(7);
                        document.getElementById("updateBrand").setAttribute("data", id);
                        $.ajax ({
                            method:"GET",
                            url: `/Project/routes/web.php/v1/getBrand/${id}`,
                            success: function(result) {
                                console.log(result);
                                if (result.status == 200) {
                                    const category = document.querySelectorAll(".productCategory");
                                    category.forEach(category => {
                                        if (category.value == result.brand[0].category) {
                                            category.setAttribute("selected", "");
                                        }
                                    })
                                    document.getElementById("updatedBrand").value = result.brand[0].brand;
                                }
                            }
                        });

                    })
                })

                const deleteButton = document.querySelectorAll(".deleteButton");
                deleteButton.forEach(button => {
                    button.addEventListener("click", () => {
                        const id = button.getAttribute("id").slice(4);
                        console.log(id);
                        deleteBrandPopup(id);
                    })
                });

                const updateBrand= document.getElementById("updateBrand");
                updateBrand.addEventListener("click", () => {
                    console.log(updateBrand);
                    const id = updateBrand.getAttribute("data");
                    const categoryName = document.getElementById("updatedCategory").value;
                    const brandName = document.getElementById("updatedBrand").value;
                    $.ajax ({
                        method: "POST",
                        url: `/Project/routes/web.php/v1/updateBrand/${id}`,
                        data: {
                            categoryName: categoryName,
                            brandName: brandName
                        },
                        success: function(result) {
                            if (result == 200) {
                                window.location.reload();
                            }
                        }
                    })
                })
                $(".table").DataTable();

            }
        }
    });

    const deleteBrandPopup = (id) => {
        Swal.fire({
            title: 'Are you sure to delete this brand?',
            text: "You won't be able to retrive this brand!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteBrand(id);
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Brand deleted successfully!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    const deleteBrand = (id) => {
        $.ajax ({
            method: "DELETE",
            url: `/Project/routes/web.php/v1/deleteBrand/${id}`,
            success: function(result) {
                console.log(result);
            }
        })
    }

    $.ajax({
        method: 'GET',
        url: '/Project/routes/web.php/v1/getCategory',
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                result.categories.forEach((value) => {
                    const product1 = document.createElement("option");
                    const product2 = document.createElement("option");

                    document.getElementById("category").appendChild(product1);
                    document.getElementById("updatedCategory").appendChild(product2);

                    product1.classList.add("productCategory", "text-center");
                    product1.setAttribute("id", value.id);
                    product1.innerHTML = value.name;

                    product2.classList.add("productCategory", "text-center");
                    product2.setAttribute("id", value.id);
                    product2.innerHTML = value.name;
                })
            } else {
                document.getElementsByClassName("categories")[0].innerHTML = result.response.message;
            }
        }
    });

    const addNewBrand = document.getElementById("addNewBrand");
    addNewBrand.addEventListener("click", () => {
        const brandName = document.getElementById("brand").value;
        const category = document.getElementById("category").value;
        $.ajax ({
            method: "POST",
            url: `/Project/routes/web.php/v1/addBrand`,
            data: {
                brandName: brandName,
                category: category
            },
            success: function (result) {
                console.log(result);
                if (result == 200) {
                    window.location.reload();
                } else {
                    tostifyBox("Something went wrong. Try after some time!", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)");
                }
            }
        })
    })
}