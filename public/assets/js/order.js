import { numberOfProductInBag, popupBox, tostifyBox } from "./functions.js";

window.onload = () => {
    $.ajax({
        method: 'GET',
        url: `/Project/routes/web.php/v1/productInto-Order`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                productListing(result.products);

                $(document).on("click", ".cancelOrder", (event) => {
                    const id = $(event.currentTarget).attr("id");
                    popupBox("Are you sure!", "You want to cancel this order?", "question", removeOrder, id);
                });
                
            } else {
                $(".emptyBag").removeClass("empty");
                $(".products").addClass("empty");
            }
        }
    })
}

const removeOrder = (id) => {
    console.log("object");
    $.ajax ({
        method: "DELETE",
        url: `/Project/routes/web.php/v1/cancelOrder/${id}`,
        success: function (result) {
            console.log(result);
            if (result == 200) {
                numberOfProductInBag();
                window.onload();
                tostifyBox("Product move to bag", "linear-gradient(to right, #ddd6f3 , #faaca8)", "#333");
            } else {
                tostifyBox("Something went wrong", "linear-gradient(0deg, #d2f07e 0%, #FFFF00 100%)", "#333");
            }
        }
    })
}

const productListing = (products) => {
    document.getElementsByClassName("productListing")[0].innerHTML = "";
    products.forEach((product, index) => {
        const productDetail = document.createElement("div");
        document.getElementsByClassName("productListing")[0].appendChild(productDetail);
        productDetail.classList.add("productDetail", "d-flex");

        const removeProduct = document.createElement("div");
        document.getElementsByClassName("productDetail")[index].appendChild(removeProduct);
        removeProduct.classList.add("removeProduct", "d-flex", "justify-content-end", "m-2");

        const remove = document.createElement("i");
        document.getElementsByClassName("removeProduct")[index].appendChild(remove);
        remove.classList.add("remove", "fa-solid", "fa-xmark");
        remove.setAttribute("id", product.id);

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

        const productPlaceStatus = document.createElement("div");
        document.getElementsByClassName("productDetails")[index].appendChild(productPlaceStatus);
        productPlaceStatus.classList.add("productPlaceStatus");

        const productStatus = document.createElement("h5");
        document.getElementsByClassName("productPlaceStatus")[index].appendChild(productStatus);
        productStatus.classList.add("productStatus");
        productStatus.innerHTML = `Status: ${product.status}`;

        const deliveryDay = document.createElement("div");
        document.getElementsByClassName("productDetails")[index].appendChild(deliveryDay);
        deliveryDay.classList.add("deliveryDay");

        if (product.status == 'accepted') {
            const days = document.createElement("p");
            document.getElementsByClassName("productPlaceStatus")[index].appendChild(days);
            days.classList.add("days");
            
            if (product.delivery_day === 'nextDay') {
                days.innerHTML = `Expected delivery day: Next Day`;
            } else if (product.delivery_day === 'withInThree') {
                days.innerHTML = `Expected delivery day: With In 3 Days`;
            } else if (product.delivery_day === 'withInFive') {
                days.innerHTML = `Expected delivery day: With In 5 Days`;
            } else if (product.delivery_day === 'withInWeek') {
                days.innerHTML = `Expected delivery day: With In Week`;
            } else {
                days.innerHTML = `Expected delivery day: With In 15 Days`;
            }
        }




        if (product.status != 'delivered') {
            const cancelOrder = document.createElement("p");
            document.getElementsByClassName("productPlaceStatus")[index].appendChild(cancelOrder);
            cancelOrder.classList.add("cancelOrder", "text-danger");
            cancelOrder.setAttribute("id", product.order_id);
            cancelOrder.innerHTML = "Cancel order";
        }
    });
}