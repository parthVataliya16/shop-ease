import { popupBox } from "./functions.js";

window.onload = () => {
    $.ajax ({
        method: "POST",
        url: `/practice/Project/routes/web.php/v1/orderSuccessfull`,
        data: {
            quantity: localStorage.getItem("quantity")
        },
        success: function(result) {
            if ( result== 200) {
                window.location.replace("orders.php");
            } else {
                window.location.replace("orders.php");  
                popupBox("Something went wrong");
            }
        }
    });
    console.log(localStorage.getItem("quantity"));
}