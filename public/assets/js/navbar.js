$(document).ready(function() {
    $.ajax ({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/getCategory`,
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                result.categories.forEach(category => {
                    const productCategory = document.createElement("a");
                    document.getElementsByClassName("dropdownMenu")[0].appendChild(productCategory);
                    productCategory.setAttribute("href", `product.php?category=${category.name}`);
                    productCategory.innerHTML = category.name
                })
            }
        }
    });
})