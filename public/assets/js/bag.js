import { popupBox, tostifyBox } from "./functions.js";

window.onload = () => {
    $.ajax({
        method: 'GET',
        url: '/Project/routes/web.php/v1/productInto-Bag',
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                productListing(result.products);
            } else {
                $(".emptyBag").removeClass("empty");
                $(".products").addClass("empty");
            }
        }
    })
}

const productListing = (products) => {
    products.forEach((product, index) => {
        const productDetail = document.createElement("div");
        document.getElementsByClassName("productListing")[0].appendChild(productDetail);
        productDetail.classList.add("productDetail", "d-flex");

        const removeProduct = document.createElement("div");
        document.getElementsByClassName("productDetail")[index].appendChild(removeProduct);
        removeProduct.classList.add("removeProduct", "d-flex", "justify-content-end", "m-2");

        const productImage = document.createElement("div");
        document.getElementsByClassName("productDetail")[index].appendChild(productImage);
        productImage.classList.add("productImage");

        const image = document.createElement("img");
        document.getElementsByClassName("productImage")[index].appendChild(image);
        image.setAttribute("src", `./../../public/uploads/${product.thumbnail}`);

        const productDetails = document.createElement("div");
        document.getElementsByClassName("productDetail")[index].appendChild(productDetails);
        productDetails.classList.add("productDetails");

        const productDetailPage = document.createElement("a");
        document.getElementsByClassName("productDetails")[index].appendChild(productDetailPage);
        productDetailPage.classList.add("productDetailPage");
        productDetailPage.setAttribute("href", `productDetail.php?id=${product.id}`);

        const productBrand = document.createElement("div");
        document.getElementsByClassName("productDetailPage")[index].appendChild(productBrand);
        productBrand.classList.add("productBrand");

        const brand = document.createElement("h4");
        document.getElementsByClassName("productBrand")[index].appendChild(brand);
        brand.classList.add("brand");
        brand.innerHTML = product.brand.charAt(0).toUpperCase() + product.brand.slice(1);

        const productName = document.createElement("div");
        document.getElementsByClassName("productDetailPage")[index].appendChild(productName);
        productName.classList.add("productName");

        const name = document.createElement("p");
        document.getElementsByClassName("productName")[index].appendChild(name);
        name.classList.add("name");
        name.innerHTML = product.name.charAt(0).toUpperCase() + product.name.slice(1);

        const price = document.createElement("div");
        document.getElementsByClassName("productDetails")[index].appendChild(price);
        price.classList.add("price", "d-flex");

        const discoutPrice = document.createElement("p");
        document.getElementsByClassName("price")[index].appendChild(discoutPrice);
        discoutPrice.classList.add("discountPrice");
        discoutPrice.innerHTML = `&#8377;${Math.round(product.price - (product.price * (product.discount / 100)))}`;

        const originalPrice = document.createElement("p");
        document.getElementsByClassName("price")[index].appendChild(originalPrice);
        originalPrice.classList.add("originalPrice", "text-decoration-line-through", "ms-2");
        originalPrice.innerHTML = `&#8377;${product.price}`;

        const discount = document.createElement("p");
        document.getElementsByClassName("price")[index].appendChild(discount);
        discount.classList.add("discount", "ms-2");
        discount.innerHTML = `${product.discount}%`;

        const productQuantity = document.createElement("div");
        document.getElementsByClassName("productDetails")[index].appendChild(productQuantity);
        productQuantity.classList.add("productQuantity");

        const numberOfProductQuantityClass = document.getElementsByClassName("productQuantity").length;
        const quantity = document.createElement("div");
        document.getElementsByClassName("productQuantity")[numberOfProductQuantityClass - 1].appendChild(quantity);
        quantity.classList.add("quantity");

        const numberOfQuantityClass = document.getElementsByClassName("quantity").length;
        const reduceQuantity = document.createElement("button");
        document.getElementsByClassName("quantity")[numberOfQuantityClass - 1].appendChild(reduceQuantity);
        reduceQuantity.classList.add("reduceQuantity");
        reduceQuantity.setAttribute("disabled", "");
        reduceQuantity.innerHTML = "-";

        const numberOfQuantity = document.createElement("input");
        document.getElementsByClassName("quantity")[numberOfQuantityClass - 1].appendChild(numberOfQuantity);
        numberOfQuantity.classList.add("numberOfQuantity");
        numberOfQuantity.setAttribute("disabled", "");
        numberOfQuantity.setAttribute("id", `${product['quantity']}_${product.id}`);
        numberOfQuantity.value = "1";

        const addQuantity = document.createElement("button");
        document.getElementsByClassName("quantity")[numberOfQuantityClass - 1].appendChild(addQuantity);
        addQuantity.classList.add("addQuantity");
        addQuantity.innerHTML = "+";

        const quantityError = document.createElement("span");
        document.getElementsByClassName("productQuantity")[numberOfProductQuantityClass - 1].appendChild(quantityError);
        quantityError.classList.add("text-danger", "mt-2", "d-flex", "justify-content-center");
        quantityError.setAttribute("id", "quantityError");

        const remove = document.createElement("p");
        document.getElementsByClassName("productQuantity")[numberOfProductQuantityClass - 1].appendChild(remove);
        remove.classList.add("remove", 'text-danger');
        remove.setAttribute("id", product.id);
        remove.innerHTML = "Remove item";
    });

    const removeFromBagButton = document.querySelectorAll(".remove");
    removeFromBagButton.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id");
            popupBox("Are you sure", "You want to remove this product from bag", "question", removeFromBag, id);
        })
    });

    const addQuantity = document.querySelectorAll(".addQuantity");
    addQuantity.forEach((button) => {
        button.addEventListener("click", () => {
            let current = button.previousSibling.value;
            const totalQuantity = button.previousSibling.getAttribute("id").split("_")[0];
            console.log(totalQuantity);
            current++;
            if (current <= totalQuantity) {
                button.previousSibling.value = current;
                button.parentElement.nextSibling.innerHTML = "";
            } else {
                button.setAttribute("disabled", "");
                button.parentElement.nextSibling.innerHTML = "Out of stock"
            }
            button.previousSibling.previousSibling.removeAttribute("disabled");
            totalMRP();
        });
    });

    const removeQuantity = document.querySelectorAll(".reduceQuantity");
    removeQuantity.forEach((button) => {
        button.addEventListener("click", () => {
            let current = button.nextSibling.value;
            current--;
            if (current > 0) {
                button.nextSibling.value = current;
                button.nextSibling.nextSibling.removeAttribute("disabled");
                button.parentElement.nextSibling.innerHTML = "";
            } else {
                button.setAttribute("disabled", "");
            }
            totalMRP();
        });
    });
    totalMRP();
}

const removeFromBag = (id) => {
    console.log(id);
    $.ajax({
        method: 'DELETE',
        url: `/Project/routes/web.php/v1/removeProductFromBag/${id}`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                tostifyBox("Product remove from bag", "linear-gradient(#7e49e5, #a0dfff)", "#ffffff");
                document.getElementsByClassName("productListing")[0].innerHTML = "";
                window.onload();
            } else {
                tostifyBox("Something wend wrong!", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)", "#000000");
            }
        }
    });
}

const totalMRP = () => {
    let totalMRP = 0;
    let discountMRP = 0;
    let quantityArr = [];
    const allProductMRP = document.querySelectorAll(".discountPrice");
    const discoutnOfAllProduct = document.querySelectorAll(".originalPrice");
    const quantityOfAllProduct = document.querySelectorAll(".numberOfQuantity");
    allProductMRP.forEach((productMRP, index) => {
        const quantity = quantityOfAllProduct[index].value;
        const mrp = + productMRP.innerHTML.slice(1);
        const discount = + discoutnOfAllProduct[index].innerHTML.slice(1);
        discountMRP += (discount - mrp) * quantity;
        totalMRP += mrp*quantity;
        console.log(quantityOfAllProduct[index]);
        const arr = [quantityOfAllProduct[index].getAttribute('id').split("_")[1], quantity];
        
        quantityArr.push(arr);
    });
    document.getElementsByClassName("mrp")[0].innerHTML =  `&#8377;${totalMRP}`;
    document.getElementsByClassName("discountMRP")[0].innerHTML = `-&#8377;${discountMRP}`;
    document.getElementsByClassName("amount")[0].innerHTML = `&#8377;${totalMRP + 20}`;

    console.log(quantityArr);
    localStorage.setItem("quantity", JSON.stringify(quantityArr));
}

const orderButton = document.getElementsByClassName("order")[0];
orderButton.addEventListener("click", () => {
    const mrp = document.getElementsByClassName("mrp")[0].innerHTML;
    const discountMrp = document.getElementsByClassName("discountMRP")[0].innerHTML;
    const amount = document.getElementsByClassName("amount")[0].innerHTML;
    localStorage.setItem("mrp", mrp);
    localStorage.setItem("discountMRP", discountMrp);
    localStorage.setItem("amount", amount);

})