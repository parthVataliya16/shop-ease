import { tostifyBox } from "./functions.js";

window.onload = () => {
    const submitButton = document.getElementById("submit");
    submitButton.addEventListener("click", (event) => {
        event.preventDefault();
        const form = document.getElementById("loginForm");
        const formData = new FormData(form);
        $.ajax({
            method: 'POST',
            url: `/practice/Project/routes/web.php/v1/login`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                console.log(result);
                if (result.response.status == 200) {
                    if (result.user[0].role == "admin") {
                        window.location.replace("./../admin/dashboard.php");
                    } else {
                        window.location.replace("./../users/index.php");
                    }
                } else {
                    tostifyBox("Invalid username or password", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)");
                }
            }
        })
    })
    
}