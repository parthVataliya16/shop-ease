window.onload = () => {
    $(".loader").removeClass("hideLoader");
    $.ajax ({
        method: "POST",
        url: `/Project/routes/web.php/v1/orderSuccessfull`,
        data: {
            quantity: localStorage.getItem("quantity")
        },
        success: function(result) {
            if ( result== 200) {
                window.location.replace("orders.php");
            } else {
                window.location.replace("orders.php");  
            }
        }
    });
    console.log(localStorage.getItem("quantity"));
}