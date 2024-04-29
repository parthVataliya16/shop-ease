import { tostifyBox } from "./functions.js";

window.onload = () => {
    $.ajax ({
        method: "GET",
        url: "/practice/Project/routes/web.php/v1/getCategory",
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                $(".loader").addClass("hideLoader");
                $(".categoryTable").removeClass("hideLoader");
                $(".sidebar").removeClass("hideLoader");

                result.categories.forEach((category, index) => {
                    const tableRow = document.createElement("tr");
                    document.getElementsByClassName("categories")[0].appendChild(tableRow);
                    tableRow.classList.add("tableRow");

                    const numberOfRow = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(numberOfRow);
                    numberOfRow.innerHTML = index + 1;

                    const name = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(name);
                    name.innerHTML = category.name;

                    const numberOfProduct = document.createElement("td");
                    document.getElementsByClassName("tableRow")[index].appendChild(numberOfProduct);
                    numberOfProduct.innerHTML = category.numberOfProduct;

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
                    deleteButton.setAttribute("id", `btn_${category.id}`)
                    deleteButton.innerHTML = "Delete"
                    
                    const updateButton = document.createElement("button");
                    document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(updateButton);
                    updateButton.classList.add("btn", "btn-primary", "updateButton");
                    updateButton.setAttribute("data-bs-toggle", "modal");
                    updateButton.setAttribute("data-bs-target", "#updateCategory");
                    updateButton.setAttribute("id", `update_${category.id}`);
                    updateButton.innerHTML = "Update";
                });

                

                const updateButton = document.querySelectorAll(".updateButton");
                updateButton.forEach(button => {
                    button.addEventListener("click", () => {
                        const id = button.getAttribute("id").slice(7);
                        document.getElementById("updateCategoryName").setAttribute("data", id);
                        $.ajax ({
                            method:"GET",
                            url: `/practice/Project/routes/web.php/v1/getCategory/${id}`,
                            success: function(result) {
                                if (result.response.status == 200) {
                                    document.getElementById("catName").value = result.categories[0].name;
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
                        deleteCategoryPopup(id);
                    })
                });

                const updateCategory = document.getElementById("updateCategoryName");
                updateCategory.addEventListener("click", () => {
                    console.log(updateCategory);
                    const id = updateCategory.getAttribute("data");
                    const categoryName = document.getElementById("catName").value;
                    $.ajax ({
                        method: "POST",
                        url: `/practice/Project/routes/web.php/v1/updateCategory/${id}`,
                        data: {
                            categoryName: categoryName
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

    const deleteCategoryPopup = (id) => {
        Swal.fire({
            title: 'Are you sure to delete this category?',
            text: "You won't be able to retrive this category!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteCategory(id);
                Swal.fire({
                    title: 'Deleted!',
                    text: 'category deleted successfully!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    const deleteCategory = (id) => {
        $.ajax ({
            method: "DELETE",
            url: `/practice/Project/routes/web.php/v1/deleteCategory/${id}`,
            success: function(result) {
                console.log(result);
            }
        })
    }

    const addNewCategory = document.getElementById("addNewCategory");
    
    addNewCategory.addEventListener("click", () => {
        const categoryName = document.getElementById("categoryName").value;
        $.ajax ({ 
            method: "POST",
            url: "/practice/Project/routes/web.php/v1/addNewCategory",
            data: {
                categoryName : categoryName
            },
            success: function(result) {
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