const tostifyBox = (msg, bgColor, color = "#FFFFFF") => {
    Toastify({
        text: msg,
        close: true,
        stopOnFocus: true,
        style: {
            background: bgColor ,
            color: color
          },
    }).showToast();
}

const popupBox = (title, text, icon, isConfirmedFunction, id) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true
    }). then((result) => {
        if (result.isConfirmed) {
            isConfirmedFunction(id);
        }
    })
}

const addToCart = (id) => {
    $.ajax({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/addToCart/${id}`,
        success: function(result) {
            console.log(result);
            if (result.status == 201) {
                tostifyBox("Product added to the cart.", "linear-gradient(to right, #ddd6f3 , #faaca8)", "#333");
            } else if (result.status == 400) {
                tostifyBox("Product is already added into the cart!", "linear-gradient(0deg, #d2f07e 0%, #FFFF00 100%)", "#333");
            } else {
                tostifyBox("Something went wrong!", "linear-gradient(0deg, #d2f07e 0%, #FFFF00 100%)", "#333");
            }
        }
    })
}

const addToBag = (id) => {
    $.ajax({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/addToBag/${id}`,
        success: function(result) {
            console.log(result);
            if (result.status == 201) {
                tostifyBox("Product added to the bag.", "linear-gradient(to right, #ddd6f3 , #faaca8)", "#333");
            } else if (result.status == 400) {
                tostifyBox("Product is already added into the bag!", "linear-gradient(0deg, #d2f07e 0%, #FFFF00 100%)", "#333");
            } else {
                tostifyBox("Something went wrong!", "linear-gradient(0deg, #d2f07e 0%, #FFFF00 100%)", "#333");
            }
        }
    })
}

const productListing = (products) => {
    document.getElementById("allProducts").innerHTML = "";
    products.forEach((value, index) => {
        if (index % 3 == 0) {
            const row = document.createElement("div");
            document.getElementsByClassName("allProducts")[0].appendChild(row);
            row.classList.add("row", "productRow", "me-0");
        }

        const numberOfProductRowClass = document.getElementsByClassName("productRow").length;
        const productData = document.createElement("div");
        document.getElementsByClassName("productRow")[numberOfProductRowClass - 1].appendChild(productData);
        productData.classList.add("col-lg-4", "col-md-4", "col-sm-6", "productData");

        const numberOfProductDataClass = document.getElementsByClassName("productData").length;
        const productBorder = document.createElement("div");
        document.getElementsByClassName("productData")[numberOfProductDataClass - 1].appendChild(productBorder);
        productBorder.classList.add("productBorder");


        const product = document.createElement("div");
        document.getElementsByClassName("productBorder")[numberOfProductDataClass - 1].appendChild(product);
        product.classList.add("product");
        product.setAttribute("id", value['id']);

        const numberOfProductClass = document.getElementsByClassName("product").length;
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
        productName.classList.add("productName", "ms-4");

        const numberOfProductNameClass = document.getElementsByClassName("productName").length;
        // const brand = document.createElement("h5");
        // document.getElementsByClassName("productName")[numberOfProductNameClass - 1].appendChild(brand);
        // brand.classList.add("brand");
        // brand.innerHTML = value['brand'].charAt(0).toUpperCase() + value['brand'].slice(1);

        const name = document.createElement("h6");
        document.getElementsByClassName("productName")[numberOfProductNameClass - 1].appendChild(name);
        name.classList.add("name");

        if (value['name'].length > 22) {
            name.innerHTML = value['name'].charAt(0).toUpperCase() + value['name'].slice(1, 22) + "...";
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
        const addToCart = document.createElement("div");
        document.getElementsByClassName("buttons")[numberOfButtonsClass - 1].appendChild(addToCart);
        addToCart.classList.add("addToCart");

        const numberOfAddToCartClass = document.getElementsByClassName("addToCart").length;
        const addTocartButton = document.createElement("button");
        document.getElementsByClassName("addToCart")[numberOfAddToCartClass - 1].appendChild(addTocartButton);
        addTocartButton.classList.add("addToCartButton", "btn");
        addTocartButton.innerHTML = "Add To Wishlist";
        addTocartButton.setAttribute("id", `${value['id']}`);
    });

    const addToCartButtons = document.querySelectorAll(".addToCartButton");
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id");
            addToCart(id);
        })
    });
}

export {tostifyBox, addToCart, addToBag, productListing, popupBox};