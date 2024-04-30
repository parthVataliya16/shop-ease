const token = window.location.search.slice(7);
console.log(token);

$.ajax({
    method: 'GET',
    url: `/practice/project /routes/web.php/v1/linkExpire?token=${token}`,
    success: function(result) {
        if (result.status != 200) {
            alertBox("", "Invalid link!", "error");
        }
    }
})

const resetPassword = document.getElementById("resetPassword");
resetPassword.addEventListener("click", (event) => {
    event.preventDefault();

    const token = window.location.search.slice(7);
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password == confirmPassword) {
        $.ajax({
            method: 'POST',
            url: `/practice/project/routes/web.php/v1/resetPassword?token=${token}`,
            data: {
                password: password
            },
            success: function(result) {
                if (result.status == 200) {
                    alertBox("Password reset", result.message , "success");
                } else {
                    alertBox("", result.message, "error");
                }
            }
        })
    } else {
        document.getElementById("error").innerHTML = "Confirm password must be same";
    }
})

const alertBox = (title, text, icon) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace("signin.php");
        }
    })
}