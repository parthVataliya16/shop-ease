import { addToCart, addToBag, productListing } from "./functions.js";
// import  {productListing} from "./index.js";

$(document).ready(function() {
    const id = window.location.search.slice(4);

    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/getProduct/${id}`,
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                result.products.forEach((value) => {
                    categoricalProducts(value.category_id);
                    const thumbnail = $(".thumbnail");
                    thumbnail.attr("src", `./../../public/uploads/${value.images[0]}`);

                    value.images.forEach((image) => {
                        const productImage = $("<img>").addClass("productImage").attr("src", `./../../public/uploads/${image}`);
                        $(".productImages").append(productImage);
                    });

                    $(".brand").html(value.brand.charAt(0).toUpperCase() + value.brand.slice(1));
                    $(".name").html(value.name.charAt(0).toUpperCase() + value.name.slice(1));
                    $(".description").html(value.description);
                    $(".discount").html(`-${value.discount}%`);
                    $(".offerPrice").html(`&#8377;${value.price - (value.price * (value.discount / 100))}`);
                    $(".originalPrice").html(`&#8377;${value.price}.`);
                    $(".addToCartButton").attr("id", `${value.id}`);
                    $(".buyNowButton").attr("id", `${value.id}`);

                    $(".addToCartButton").click(function() {
                        const id = $(this).attr("id");
                        addToCart(id);
                    });

                    $(".productImage").mouseenter(function() {
                        const imageName = $(this).attr("src");
                        $(".thumbnail").attr("src", imageName);
                    });

                   
                });
            }
        }
    });

    $(".buyNowButton").click(function() {
        const id = $(this).attr("id");
        addToBag(id);
    });
});

const categoricalProducts = (categoryId) => {
    $.ajax ({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/categoricalProduct/${categoryId}`,
        success: function (result) {
            console.log(result);
            if (result.status == 200) {
                productListing(result.products);
            }
        }
    })
}
