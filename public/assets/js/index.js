import { addToCart } from "./functions.js";

$(document).ready(function() {
    setTimeout(() => {
        const addToCartButtons = document.querySelectorAll(".addToCartButton");
        addToCartButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const id = button.getAttribute("id");
                addToCart(id);
            })
        });
    }, 2000)
    $(".banners").slick({
        slidesToShow: 1,
        prevArrow:false,
        nextArrow:false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        pauseOnFocus: false,
        pauseOnHover: false,
        fade: true,
        cssEase: 'linear'
    });

    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/dealProducts`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                productListing(result.products,"allProducts");
                categoryViseProduct("Smartphone", "allSmartphone");
                categoryViseProduct("Laptop", "allLaptop");
                categoryViseProduct("ac", "allAC");
                $(".allProducts").slick({
                    slidesToShow: 4,
                    arrows: false,
                    // autoplay: true,
                    autoplaySpeed: 3000,
                    pauseOnFocus: false,
                    pauseOnHover: false,
                });
            }
        }
    });
})

const categoryViseProduct = (category, className) => {
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/getProduct/${category}`,
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                productListing(result.products, className);
                $(`.${className}`).slick({
                    slidesToShow: 4,
                    arrows: false,
                    // autoplay: true,
                    // autoplaySpeed: 3000,
                    // pauseOnFocus: false,
                    // pauseOnHover: false,
                });
                // const addToCartButtons = document.querySelectorAll(".addToCartButton");
                // addToCartButtons.forEach((button) => {
                //     button.addEventListener("click", () => {
                //         const id = button.getAttribute("id");
                //         addToCart(id);
                //     })
                // });
            }
        }
    })
}

const productListing = (products,className) => {
    // console.log(className);
    products.forEach((value) => {
        const productData = document.createElement("div");
        document.getElementsByClassName(className)[0].appendChild(productData);
        productData.classList.add("productData");

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
    
}