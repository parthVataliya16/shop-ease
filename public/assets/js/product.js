import {productListing} from "./functions.js";

$(document).ready(function(){
    $(".navbar-toggler").click(function(){
        $(".cta").slideToggle(1000);
        $(".cta").css("display", "flex");
    });

    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get("category");
    console.log(category);

    if (category == null) {
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
    } else {
        $.ajax({
            method: 'GET',
            url: `/practice/Project/routes/web.php/v1/productCategoryVise/${category}`,
            success: function(result) {     
                console.log(result);
                if (result.status == 200) {
                    document.getElementsByClassName("priceFilter")[0].innerHTML = "";
                    productListing(result.products);

                    const totalPriceFilter = result.price.length;
                    result.price.forEach((price, index) => {
                        if (index != totalPriceFilter - 1) {
                        const priceFilter = document.createElement("div");
                        document.getElementsByClassName("priceFilter")[0].appendChild(priceFilter);
                        priceFilter.classList.add("price");

                        const priceAmt = document.createElement("input");
                        document.getElementsByClassName("price")[index].appendChild(priceAmt);
                        priceAmt.setAttribute("type", "checkbox");
                        priceAmt.setAttribute("name", "price");
                        priceAmt.setAttribute("id", `${price}-${result.price[index + 1]}`);

                        const priceTitle = document.createElement("label");
                        document.getElementsByClassName("price")[index].appendChild(priceTitle);
                        priceTitle.classList.add("ms-2");
                        priceTitle.innerHTML = `&#8377;${price} to &#8377;${result.price[index + 1]}`;
                        } else {
                            return;
                        }
                    });

                    document.getElementsByClassName("brand-title")[0].innerHTML = "Brand";

                    result.brand.forEach((brand, index) => {
                        const brandFilter = document.createElement("div");
                        document.getElementsByClassName("brandFilter")[0].appendChild(brandFilter);
                        brandFilter.classList.add("brand");

                        const brandCheckbox = document.createElement("input");
                        document.getElementsByClassName("brand")[index].appendChild(brandCheckbox);
                        brandCheckbox.setAttribute("type", "checkbox");
                        brandCheckbox.setAttribute("name", "brand");
                        brandCheckbox.setAttribute("id", brand);

                        const brandTitle = document.createElement("label");
                        document.getElementsByClassName("brand")[index].appendChild(brandTitle);
                        brandTitle.classList.add("ms-2");
                        brandTitle.innerHTML = brand.brand_name;
                    })
                } else {
                    // document.getElementById("allProducts").innerHTML = result.response.message;
                }
            }
        });
    }

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
