window.onload = () => {
    const registerUser = document.getElementById("registerUser");
    registerUser.addEventListener("click", (event) => {
        event.preventDefault();
        const form = document.getElementById("registerForm");
        const formData = new FormData(form);
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (password === confirmPassword) {
            $.ajax({
                method: 'POST',
                url: '/practice/Project/routes/web.php/v1/register',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    console.log(result);
                    if (result.status == 201) {
                        window.location.replace('./../users/index.php');
                    } else {
                        document.getElementById("error").innerHTML = result.message;
                    }
                }
            })
        } else {
            document.getElementById("passwordError").innerHTML = "Password must be same";
        }
    })
}