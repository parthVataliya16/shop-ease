import {productListing} from "./functions.js";

$(document).ready(function(){
    $(".navbar-toggler").click(function(){
        $(".cta").slideToggle(1000);
        $(".cta").css("display", "flex");
    });

    // $.ajax({
    //     method: 'GET',
    //     url: `/practice/Project/routes/web.php/v1/getCategory`,
    //     success: function(result) {
    //         if (result.response.status == 200) {
    //             result.categories.forEach(category => {
    //                 const checkBoxDiv = document.createElement("div");
    //                 document.getElementsByClassName("productCategory")[0].appendChild(checkBoxDiv);
    //                 checkBoxDiv.classList.add("checkBox");

    //                 const numberOfCheckBoxClass = document.getElementsByClassName("checkBox").length;
    //                 const checkBox = document.createElement("input");
    //                 document.getElementsByClassName("checkBox")[numberOfCheckBoxClass - 1].appendChild(checkBox);
    //                 checkBox.setAttribute("type", "checkbox");
    //                 checkBox.setAttribute("id", category.id);
    //                 checkBox.setAttribute("name", "product-category");

    //                 const label = document.createElement("label");
    //                 document.getElementsByClassName("checkBox")[numberOfCheckBoxClass - 1].appendChild(label);
    //                 label.classList.add("ms-3")
    //                 label.setAttribute("value", category['name']);
    //                 label.innerHTML = category['name'];
    //             });

    //             let selectedCategoriesArr = [];
    //             const productCategories = document.querySelectorAll("input[type='checkbox']");
    //             productCategories.forEach(category => {
    //                 category.addEventListener("click", () => {
    //                     const id = category.getAttribute('id');
    //                     console.log(selectedCategoriesArr.includes(id));
    //                     if (selectedCategoriesArr.includes(id)) {
    //                         const index = selectedCategoriesArr.indexOf(id);
    //                         selectedCategoriesArr.splice(index, 1);
    //                     } else {
    //                         selectedCategoriesArr.push(id);
    //                     }
    //                     console.log(selectedCategoriesArr);
    //                     const categoryId = selectedCategoriesArr.toString();
    //                     filterProductCategoryVise(categoryId);
    //                 });
    //             })
    //         }
    //     }
    // });

    // const category = document.querySelectorAll("input[type='radio']");
    // category.forEach(category => {
    //     category.addEventListener("click", () => {
    //         let selectedCategoriesArr = [];
    //         $("input:checkbox[name=product-category]:checked").each(function(){
    //             selectedCategoriesArr.push($(this).attr('id'));
    //         });
    //         console.log(selectedCategoriesArr);
    //         const categoryId = selectedCategoriesArr.toString();
    //         console.log(categoryId);
    //         filterProductCategoryVise(categoryId);
    //     })
    // })

    $.ajax({
        method: 'GET',
        url: '/practice/Project/routes/web.php/v1/getProductsToUser',
        success: function(result) {
            if (result.response.status == 200) {
                productListing(result.products);
                
            } else {
                document.getElementById("allProducts").innerHTML = result.response.message;
            }
        }
    });

    document.getElementById("searchProduct").addEventListener("keyup", () => {
        const searchValue = document.getElementById("searchProduct").value;
        $.ajax({
            method: 'GET',
            url: `/practice/Project/routes/web.php/v1/getProductsToUser?productName=${searchValue}`,
            success: function (result) {
                if (result.response.status == 200) {
                    productListing(result.products);
                } else {
                    document.getElementById("allProducts").innerHTML = "";
                    document.getElementById("error").innerHTML = result.response.message;
                }
            }
        })
    });
    
});

const filterProductCategoryVise = (categoryId) => {
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/productCategoryVise?categoryId=${categoryId}`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                $(".products").removeClass("empty");
                $(".noProduct").addClass("empty");  
                productListing(result.products);
            } else {
                $(".products").addClass("empty");
                $(".noProduct").removeClass("empty");  
            }
        }
    })
}



// export {productListing};