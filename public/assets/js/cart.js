import {tostifyBox, addToBag, popupBox} from "./functions.js";

window.onload = () => {
    const productIntoCart = localStorage.getItem("cart");
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/productIntoCart`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                productListing(result.products);
            } else {
                $(".emptyCart").css("display", "flex");
            }
        }
    })
}

const productListing = (products) => {
    products.forEach((value, index) => {
        if (index % 4 == 0) {
            const row = document.createElement("div");
            document.getElementsByClassName("productIntoCart")[0].appendChild(row);
            row.classList.add("row", "productRow", "me-0");
        }
        
        const numberOfProductRowClass = document.getElementsByClassName("productRow").length;
        const productData = document.createElement("div");
        document.getElementsByClassName("productRow")[numberOfProductRowClass - 1].appendChild(productData);
        productData.classList.add("col-lg-3", "col-md-3", "col-sm-6", "productData");

        const numberOfProductDataClass = document.getElementsByClassName("productData").length;
        const product = document.createElement("div");
        document.getElementsByClassName("productData")[numberOfProductDataClass - 1].appendChild(product);
        product.classList.add("product");
        product.setAttribute("id", value['id']);

        const numberOfProductClass = document.getElementsByClassName("product").length;
        const removeProduct = document.createElement("div");
        document.getElementsByClassName("product")[numberOfProductClass - 1].appendChild(removeProduct);
        removeProduct.classList.add("removeProduct", "d-flex", "justify-content-end", "mt-2", "me-2", "mb-2");

        const numberOfRemoveProductClass = document.getElementsByClassName("removeProduct").length;
        const remove = document.createElement("i");
        document.getElementsByClassName("removeProduct")[numberOfRemoveProductClass - 1].appendChild(remove);
        remove.classList.add("remove", "fa-solid", "fa-xmark");
        remove.setAttribute("id", value.id);

        const moreDetail = document.createElement("a");
        document.getElementsByClassName("product")[numberOfProductClass - 1].appendChild(moreDetail);
        moreDetail.classList.add("productDetail", "text-dark", "text-decoration-none");
        moreDetail.setAttribute("href", `productDetail.php?id=${value.id}`);

        const numberOfMoreDetailClass = document.getElementsByClassName("productDetail").length;
        const productImage = document.createElement("div");
        document.getElementsByClassName("productDetail")[numberOfMoreDetailClass - 1].appendChild(productImage);
        productImage.classList.add("productImage");

        const numberOfProductImageClass = document.getElementsByClassName("productImage").length;
        const image = document.createElement("img");
        document.getElementsByClassName("productImage")[numberOfProductImageClass - 1].appendChild(image);
        image.classList.add("image");
        image.setAttribute("src", `./../../public/uploads/${value['thumbnail']}`);

        if (image.clientHeight > 240) {
            image.classList.add("imageHeight");
        }

        const productDetail = document.createElement("div");
        document.getElementsByClassName("productDetail")[numberOfMoreDetailClass - 1].appendChild(productDetail);
        productDetail.classList.add("productDetail");

        const numberOfProductDetailClass = document.getElementsByClassName("productDetail").length;
        const productName = document.createElement("div");
        document.getElementsByClassName("productDetail")[numberOfProductDetailClass - 1].appendChild(productName);
        productName.classList.add("productName", "mt-3", "ms-4");

        const numberOfProductNameClass = document.getElementsByClassName("productName").length;
        // const brand = document.createElement("h5");
        // document.getElementsByClassName("productName")[numberOfProductNameClass - 1].appendChild(brand);
        // brand.classList.add("brand");
        // brand.innerHTML = value['brand'].charAt(0).toUpperCase() + value['brand'].slice(1);

        const name = document.createElement("h5");
        document.getElementsByClassName("productName")[numberOfProductNameClass - 1].appendChild(name);
        name.classList.add("name");

        if (value['name'].length > 12) {
            name.innerHTML = value['name'].charAt(0).toUpperCase() + value['name'].slice(1, 12) + "...";
        } else {
            name.innerHTML = value['name'].charAt(0).toUpperCase() + value['name'].slice(1);
        }

        const productPrice = document.createElement("div");
        document.getElementsByClassName("productDetail")[numberOfProductDetailClass - 1].appendChild(productPrice);
        productPrice.classList.add("productPrice", "mt-1");

        const numberOfProductPriceClass = document.getElementsByClassName("productPrice").length;
        const price = document.createElement("p");
        document.getElementsByClassName("productPrice")[numberOfProductPriceClass - 1].appendChild(price);
        price.classList.add("price", "d-flex", "ms-4");

        const numberOfPriceClass = document.getElementsByClassName("price").length;
        const originalPrice = document.createElement("span");
        document.getElementsByClassName("price")[numberOfPriceClass - 1].appendChild(originalPrice);
        originalPrice.classList.add("originalPrice");
        originalPrice.innerHTML = `&#8377;${Math.round(value['price'] - (value['price'] * (value['discount'] / 100)))}`;

        const discountPrice = document.createElement("span");
        document.getElementsByClassName("price")[numberOfPriceClass - 1].appendChild(discountPrice);
        discountPrice.classList.add("discountPrice", "text-decoration-line-through", "ms-2");
        discountPrice.innerHTML = `&#8377;${value['price']}`;

        const discount = document.createElement("span");
        document.getElementsByClassName("price")[numberOfPriceClass - 1].appendChild(discount);
        discount.classList.add("discount", "ms-2");
        discount.innerHTML = `(${value['discount']}% OFF)`;

        const buttons = document.createElement("div");
        document.getElementsByClassName("product")[numberOfProductClass - 1].appendChild(buttons);
        buttons.classList.add("buttons");

        const numberOfButtonsClass = document.getElementsByClassName("buttons").length;
        const addToBag = document.createElement("div");
        document.getElementsByClassName("buttons")[numberOfButtonsClass - 1].appendChild(addToBag);
        addToBag.classList.add("addToBag");

        const numberOfAddToBagClass = document.getElementsByClassName("addToBag").length;
        const addToBagButton = document.createElement("button");
        document.getElementsByClassName("addToBag")[numberOfAddToBagClass - 1].appendChild(addToBagButton);
        addToBagButton.classList.add("addToBagButton", "btn");
        addToBagButton.setAttribute("id", value.id);
        addToBagButton.innerHTML = "Add to bag"
    });

    const removeFromCartButton = document.querySelectorAll(".remove");
    removeFromCartButton.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id");
            popupBox("Are you sure", "You want to remove this product from cart", "question", removeFromCart, id);
            // removeFromCart(id);
        })
    });

    const addToBagButton = document.querySelectorAll(".addToBagButton");
    addToBagButton.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id");
            addToBag(id);
        })
    })
}

const removeFromCart = (id) => {
    console.log(id);
    $.ajax({
        method: 'DELETE',
        url: `/practice/Project/routes/web.php/v1/removeProductFromCart/${id}`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                tostifyBox("Product remove from cart", "linear-gradient(#7e49e5, #a0dfff)", "#ffffff");
                document.getElementsByClassName("productIntoCart")[0].innerHTML = "";
                window.onload();
            } else {
                tostifyBox("Something wend wrong!", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)", "#000000");
            }
        }
    })
}
